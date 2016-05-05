var server = require('http').createServer();
var io     = require('socket.io')(server);

// Funcion que parsea el csv y lo convierte a JSON
function pushCsv() {
    var x = (new Date).getTime();

    var y = Math.floor((Math.random() * ((200 + 1) - 1)) + 1);

    var coord = new Array();

    coord.push(x, y);

    io.emit('csvOutput', coord);
    // io.emit('llave', coord);
    // io.emit('bocadepozo', coord);
    // io.emit('bocadepozo', coord);

    //console.log('enviando - ');

    //console.log(io.sockets.clients().length);
}

// Detecta cuando alguien se conecta, parsea el csv y se lo manda
io.on('connection', function (socket) {
    // Intervalo de 30 segundos
    console.log('conectado');

    socket.on('event', function (data) {
    });

    socket.on('disconnect', function () {
        //console.log('desconectado');
    });
});

setInterval(function () {

    //console.log(io.);
    //if(server._connections > 1 ){
        pushCsv();
      //  console.log('enviando');
    //}

}, 500);


// Activa el server en el puerto 1337
server.listen(5140);
