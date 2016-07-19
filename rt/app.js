//var express = require('express');
//var app = express();

var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var watch = require('node-watch');
var fs    = require('fs');

const TRPL_SAI280   = '/srv/data/trpl.sai280';
const TRMAN_SAI280  = '/srv/data/trman.sai280';
const HSTPL_SAI280  = '/srv/data/hstpl.sai280';
const HSTMAN_SAI280 = '/srv/data/hstman.sai280';

const WATCH_FILES = [TRPL_SAI280,TRMAN_SAI280];


app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});

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

      default:

    }

  });

}


app.get('/sai280/hstpl', function (req, res) {

  fs.readFile(HSTPL_SAI280, 'utf8', function(err, data) {
    if( err ){
      console.log(err)
    }
    else{
      res.send(data);
    }
  });

});



/**
 * SAI 280
 */
var sai280 = io.of('/sai280');

// Detecta cuando alguien se conecta
sai280.on('connection', function (socket) {
  //console.log('conectado');

  socket.on('disconnect', function () {
    delete socket.namespace.sockets[this.id];
    //console.log('desconectado');
  });
});


try{
  watch(WATCH_FILES, function(filename) {
    //console.log(filename, ' changed.');
    push(filename);
  });

} catch (err) {
  // handle the error safely
  console.log(err)
}

app.listen(5140, function () {
  console.log('Example app listening on port 5140!');
});
