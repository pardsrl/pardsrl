var server      = require('http').createServer();
var io          = require('socket.io')(server);
var watch       = require('node-watch');

const fs = require('fs');

const TRPL_SAI280   = '/srv/data/trpl.sai280';
const TRMAN_SAI280  = '/srv/data/trman.sai280';
const HSTPL_SAI280  = '/srv/data/hstpl.sai280';
const HSTMAN_SAI280 = '/srv/data/hstman.sai280';

const WATCH_FILES = [TRPL_SAI280,TRMAN_SAI280,HSTPL_SAI280];

// Funcion que parsea el csv y lo convierte a JSON
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

        case HSTPL_SAI280:
            // Emite un evento al socket del tipo csvOutput
            sai280.emit('hstpl', data);
            break;

        default:

    }

  });

}

/**
 * SAI 280
 */
var sai280 = io.of('/sai280');

// Detecta cuando alguien se conecta
sai280.on('connection', function (socket) {
    console.log('conectado');

    socket.on('hstpl_demanda', function (data) {
        push(HSTPL_SAI280);
    });

    socket.on('disconnect', function () {
        console.log('desconectado');
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


// Activa el server en el puerto 5140
server.listen(5140);
