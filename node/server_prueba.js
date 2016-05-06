var server = require('http').createServer();
var io     = require('socket.io')(server);

// Funcion que parsea el csv y lo convierte a JSON
function pushCsv() {
    var x = (new Date).getTime();

    var aparejo    = Math.floor((Math.random() * ((150 + 1) - 1)) + 1);

    var anemometro = Math.floor((Math.random() * ((150 + 1) - 1)) + 1);

    var llave      = Math.floor((Math.random() * ((1800 + 1) - 1)) + 1);

    var boca_pozo  = Math.floor((Math.random() * ((1800 + 1) - 1)) + 1);

    var coord = new Array();

    coord.push(x, aparejo, anemometro, llave, boca_pozo);

    io.emit('equipo', coord);


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

}, 1000);


// Activa el server en el puerto 1337
server.listen(5140);
