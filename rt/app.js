//var express = require('express');
//var app = express();

var app         = require('express')();
var server      = require('http').Server(app);
var io          = require('socket.io')(server);
var watch       = require('node-watch');
var fs          = require('fs');
var compression = require('compression')


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
app.get('/:equipo/:grafica', function (req, res) {

  var equipo  = req.params.equipo;
  var grafica = req.params.grafica;

  var archivo = BASE_ARCHIVOS+grafica+'.'+equipo;

  fs.readFile(archivo, 'utf8', function(err, data) {

    res.setHeader('Content-Type', 'application/json')
    res.setHeader('Cache-Control', 'no-cache');

    if( err ){
      console.log(err)
    }
    else{
      res.write(data);

      // !!! this is the important part
      res.flush()

      res.end();
    }
  });

});

/**
 * WEBSOCKETS - TIEMPO REAL
 */

const TRPL_SAI280   = '/srv/data/trpl.sai280';
const TRMAN_SAI280  = '/srv/data/trman.sai280';
const TRPL_WTI15   = '/srv/data/trman.wti15';
const TRMAN_WTI15   = '/srv/data/trman.wti15';

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
