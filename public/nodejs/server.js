/**
 * Created by David on 2015.02.21..
 */

var app                 = require('http').createServer(),
    io                  = require('socket.io').listen(app),
    fs                  = require('fs'),
    mysql               = require('mysql'),
    connectionsArray    = [],
    connection          = mysql.createConnection({
        host        : '10.0.2.15',
        user        : 'homestead',
        password    : 'secret',
        database    : 'homestead',
        port        : '3306'
    }),
    REFRESH_INTERVAL = 5000,
    refreshTimer,
    sensorId,
    sensorLastDate;

connection.connect(function(err) {
    if (err != null) {
        console.log(err);
    }
});

app.listen(8000);

var refreshLoop = function () {

    console.log("SensorLastDate: " + sensorLastDate);

    if (sensorId != undefined && sensorLastDate != undefined) {
        var query = connection.query("SELECT * FROM measurements WHERE sensor_id = '" + sensorId + "' AND created_at > '" + sensorLastDate +"'"),
            measurements = [];

        console.log('Database query');

        query.on('error', function(err) {
                console.log(err);
                update(err);
            })
            .on('result', function(measurement) {
                measurements.push(measurement);
                console.log("Meassurement" + measurement.created_at);
                sensorLastDate = new Date(measurement.created_at).toMysqlFormat();
                console.log("SensorLastDate" + sensorLastDate);
            })
            .on('end', function() {
                if (connectionsArray.length) {
                    refreshTimer = setTimeout(refreshLoop, REFRESH_INTERVAL);

                    if (measurements.length > 0) {
                        update({measurements:measurements});
                    }
                }
            })
    }
};

io.sockets.on('connection', function (socket) {
   console.log('Connections: ' + connectionsArray.length);

    if (!connectionsArray.length) {
        refreshLoop();
    }

    socket.on('data', function(data) {
        sensorId = data.id;
        sensorLastDate = data.date;
    });

    socket.on('disconnect', function() {
        var index = connectionsArray.indexOf(socket);
        console.log('socket = ' + index + 'disconnected');
        if (index >= 0) {
            connectionsArray.splice(index, 1);
        }
    });

    console.log('A new socket is connected');
    connectionsArray.push(socket);
});

var update = function (data) {
    data.time = new Date();

    connectionsArray.forEach(function(tmp) {
       tmp.volatile.emit('notification', data);
    });
};

/* Utils */
function twoDigits(d) {
    if(0 <= d && d < 10) return "0" + d.toString();
    if(-10 < d && d < 0) return "-0" + (-1*d).toString();
    return d.toString();
}

Date.prototype.toMysqlFormat = function() {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
};
