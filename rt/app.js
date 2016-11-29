//var express = require('express');
//var app = express();

var app         = require('express')();
var server      = require('http').Server(app);
var io          = require('socket.io')(server);
var watch       = require('node-watch');
var fs          = require('fs');
var compression = require('compression')
var request     = require('request');

var config      = require('./config');

app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

// comprimir las respuestas
app.use(compression());


/**
 * Controlador que retorna los puntos de los historicos
 *
 * @param equipo El equipo que se desea obtener la grafica
 * @param grafica El tipo de grafica que se busca
 *
 */
app.get('/historico', function (req, res) {

  res.setHeader('Content-Type', 'application/json')
  res.setHeader('Cache-Control', 'no-cache');

  //console.log(req.query);

  request({
    uri: config.historico_script,
    method: "POST",
    form: req.query
  }, function(error, response, body) {

      if (!error && response.statusCode == 200){
        res.write(body);

        // !!! this is the important part
        res.flush()

        res.end();
      }else{

        error = error ? error : "Error interno del servidor de datos.";

        res.status(500).send('{ "status": "error" , "detail" : "'+ error + '" }');
      }
  });

});

/**
 * WEBSOCKETS - TIEMPO REAL
 */

var sockets = config.sockets;

var aSocketIO  = []; //array con las instancias de socket IO.
var aWatchFile = []; //array con los archivos a evaluar
var aEmitter   = []; //array con la configuracion de emision

Object.keys(sockets).forEach(function(key) {

    if(sockets[key].enable){
        aSocketIO[key] = io.of(sockets[key].namespace); //guardo la instancia socket.IO

        var channels = sockets[key].channels

        for (channel in channels ){

            var channel = channels[channel];

            if(channel.watch){
            	aWatchFile.push(channel.filename);
                aEmitter[channel.filename] = {
                    socket:  aSocketIO[key],
                    channel: channel.alias
                };
            }
        }
    }
});

//console.log(aSocketIO);
//console.log(aWatchFile);
//console.log(aEmitter);

try{
  watch(aWatchFile, function(filename) {
    //console.log(filename, ' changed.');
    push(filename);
  });

} catch (err) {
  // handle the error safely
  console.log(err)
}


function push($filename) {


  fs.readFile($filename, "utf-8", function (err, data) {

    if (err) console.log(err);

    var socket  = aEmitter[$filename].socket;
    var channel = aEmitter[$filename].channel;

    socket.emit(channel,data);

  });

}

server.listen(5140, function () {
  console.log('Servidor escuchando en puerto 5140!');
});
