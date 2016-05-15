var server    = require('http').createServer();
var io        = require('socket.io')(server);
var Converter = require("csvtojson").Converter;
var watch     = require('node-watch');

const fs = require('fs');


// Funcion que parsea el csv y lo convierte a JSON
function push($filename) {
    /*
     var x = (new Date).getTime();

     var aparejo    = Math.floor((Math.random() * ((150 + 1) - 1)) + 1);

     var anemometro = Math.floor((Math.random() * ((150 + 1) - 1)) + 1);

     var llave      = Math.floor((Math.random() * ((1800 + 1) - 1)) + 1);

     var boca_pozo  = Math.floor((Math.random() * ((1800 + 1) - 1)) + 1);

     var coord = new Array();

     coord.push(x, aparejo, anemometro, llave, boca_pozo);
     */

    // La opcion no header es para cuando no tenemos headers en el csv
    var converter = new Converter({noheader:true});

    //end_parsed will be emitted once parsing finished
    converter.on("end_parsed", function (jsonArray) {

        switch ($filename) {

            case '/srv/data/tr.sai280':
                // Emite un evento al socket del tipo csvOutput
                sai280.emit('tiempo_real', jsonArray);
                break;

            default:

        }

    });


    //read from file
    var stream = fs.createReadStream($filename);

    stream.on('error', function (error) {console.log("Caught", error);});
    stream.on('readable', function () {stream.pipe(converter);});

    //sai280.emit('equipo', coord);

    //console.log('enviando - ');

    //console.log(io.sockets.clients().length);
}


var sai280 = io.of('/tr-sai280');
// Detecta cuando alguien se conecta, parsea el csv y se lo manda
sai280.on('connection', function (socket) {

    socket.on('event', function (data) {
    });

    socket.on('disconnect', function () {
        //console.log('desconectado');
    });
});

/*
 setInterval(function () {

 //console.log(io.);
 //if(server._connections > 1 ){
 pushCsv();
 //  console.log('enviando');
 //}

 }, 1000);
 */