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

const BASE_ARCHIVOS = '/srv/data/';

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
        res.status(500).send('{ "status": "error" , "error" : "'+ error + '" }');
      }
  });

});

/**
 * WEBSOCKETS - TIEMPO REAL
 */

const TRPL_SAI280   = BASE_ARCHIVOS+'trpl.sai280';
const TRMAN_SAI280  = BASE_ARCHIVOS+'trman.sai280';
const TRPL_WTI15    = BASE_ARCHIVOS+'trpl.wti15';
const TRMAN_WTI15   = BASE_ARCHIVOS+'trman.wti15';

const WATCH_FILES = [TRPL_SAI280,TRMAN_SAI280,TRPL_WTI15,TRMAN_WTI15];

var sai280 = io.of('/sai280');
var wti15  = io.of('/wti15');


try{
  watch(WATCH_FILES, function(filename) {
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

    switch ($filename) {

      case TRPL_SAI280:
        // Emite un evento al socket del tipo csvOutput
        sai280.emit('trpl', data);
        break;

      case TRMAN_SAI280:
        // Emite un evento al socket del tipo csvOutput
        sai280.emit('trman', data);
        break;

      case TRPL_WTI15:
        // Emite un evento al socket del tipo csvOutput
        wti15.emit('trpl', data);
        break;

      case TRMAN_WTI15:
        // Emite un evento al socket del tipo csvOutput
        wti15.emit('trman', data);
        break;

      default:

    }

  });

}

server.listen(5140, function () {
  console.log('Servidor escuchando en puerto 5140!');
});
