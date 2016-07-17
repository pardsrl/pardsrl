var server      = require('http').createServer();
var io          = require('socket.io')(server);

const fs = require('fs');


// Funcion que parsea el csv y lo convierte a JSON
function push($filename) {


  fs.readFile($filename, function (err, data) {

    if (err) throw err;

    switch ($filename) {

        case '/srv/data/trpl.sai280':
            // Emite un evento al socket del tipo csvOutput
            sai280.emit('trpl', data);
            break;

        case '/srv/data/trman.sai280':
            // Emite un evento al socket del tipo csvOutput
            sai280.emit('trman', data);
            break;

        case '/srv/data/hstpl.sai280':
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
    socket.on('event', function (data) {
    });

    socket.on('disconnect', function () {
        //console.log('desconectado');
    });
});


try{
    watch(['/srv/data/trman.sai280', '/srv/data/trpl.sai280', '/srv/data/hstpl.sai280'], function(filename) {
        //console.log(filename, ' changed.');
        push(filename);
    });

} catch (err) {
    // handle the error safely
    console.log(err)
}


// Activa el server en el puerto 5140
server.listen(5140);
