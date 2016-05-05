var Converter = require("csvtojson").Converter;
var server = require('http').createServer();
var io = require('socket.io')(server);
const fs = require('fs');

var csvPath = 'data/dls68.csv';

// Funcion que parsea el csv y lo convierte a JSON
function pushCsv() {
    //Converter Class

    // La opcion no header es para cuando no tenemos headers en el csv
    var converter = new Converter({noheader:true});

    //end_parsed will be emitted once parsing finished
    converter.on("end_parsed", function (jsonArray) {
        // Emite un evento al socket del tipo csvOutput
        io.emit('csvOutput', jsonArray);
    });

    //read from file
    fs.createReadStream(csvPath).pipe(converter);
}

// Detecta cuando alguien se conecta, parsea el csv y se lo manda
io.on('connection', function (socket) {
    pushCsv();
    socket.on('event', function (data) {});
    socket.on('disconnect', function () {});
});

// Intervalo de 30 segundos
setInterval(function () {
    pushCsv();
}, 30000);


// Activa el server en el puerto 1337
server.listen(1337);