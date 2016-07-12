var server      = require('http').createServer();
var io          = require('socket.io')(server);
var Converter   = require("csvtojson").Converter;
var watch       = require('node-watch');
var mysql       = require('mysql');
var MySQLEvents = require('mysql-events');

const fs = require('fs');
const MYSQL_DATABASE = "live_data";


var dsn = {
    host:     'localhost',
    user:     'root',
    password: '123',
    database : MYSQL_DATABASE
};


var mysqlEventWatcher = MySQLEvents(dsn);


var watcher = mysqlEventWatcher.add(
    MYSQL_DATABASE+'.notificacion',
    function (oldRow, newRow) {
        //row inserted
        if (oldRow === null) {

            var id_notificacion = newRow.fields.id;

            var sistema_flag    = newRow.fields.sistema;

            //la notifiacion es de sistema
            if(sistema_flag){

                notificaciones.emit('sistema',newRow.fields);

            }else{

                var connection = mysql.createConnection(dsn);

                connection.connect();

                connection.query('SELECT * FROM notificacion_distribucion WHERE notificacion_id='+ id_notificacion +';', function(err, rows, fields) {
                    if (err) throw err;

                    //es una notificacion de equipo
                    if (fields.equipo_id) {
                        notificaciones.emit('grupal_' + fields.equipo_id, rows[0]);
                        //es una notificacion personal
                    } else {
                        notificaciones.emit('personal_' + fields.persona_id, rows[0]);

                    }
                });

                connection.end();

            }

        }

        // //row deleted
        // if (newRow === null) {
        //     //delete code goes here
        // }
        //
        // //row updated
        // if (oldRow !== null && newRow !== null) {
        //     //update code goes here
        // }
    },
    'match this string or regex'
);



// Funcion que parsea el csv y lo convierte a JSON
function push($filename) {

    // La opcion no header es para cuando no tenemos headers en el csv
    var converter = new Converter({noheader:true});

    //end_parsed will be emitted once parsing finished
    converter.on("end_parsed", function (jsonArray) {

        var dataset = Array();

        for (key in jsonArray) {
            
            var puntos = jsonArray[key].field1.split(" ");

            for(p in puntos){
                puntos[p] = Number(puntos[p]);
            }

            dataset.push(puntos);
        }

        switch ($filename) {

            case '/srv/data/trpl.sai280':
                // Emite un evento al socket del tipo csvOutput
                sai280.emit('trpl', dataset);
                break;

            case '/srv/data/trman.sai280':
                // Emite un evento al socket del tipo csvOutput
                sai280.emit('trman', dataset);
                break;

            case '/srv/data/hstpl.sai280':
                // Emite un evento al socket del tipo csvOutput
                sai280.emit('hstpl', dataset);
                break;

            default:

        }

    });


    //read from file
    var stream = fs.createReadStream($filename);

    stream.on('error', function (error) {console.log("Caught", error);});
    stream.on('readable', function () {stream.pipe(converter);});

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
    watch(['/srv/data/trman.sai280', '/srv/data/trpl.sai280','/srv/data/hstpl.sai280'], function(filename) {
        //console.log(filename, ' changed.');
        push(filename);
    });

} catch (err) {
    // handle the error safely
    console.log(err)
}


var notificaciones = io.of('/notificaciones');






// Activa el server en el puerto 5140
server.listen(5140);