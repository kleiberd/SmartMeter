/**
 * Created by David on 2015.02.21..
 */

var app = require('http').createServer(),
    io = require('socket.io').listen(app),
    fs = require('fs'),
    mysql = require('mysql'),
    connectionsArray = [],
    connectionsDatas = [],
    connection = mysql.createConnection({
        host: 'localhost',
        user: 'thesis',
        password: '03ufJU4etx5172n',
        database: 'thesis'
    }),
    REFRESH_INTERVAL = 5000,
    refreshTimer;

connection.connect(function (err) {
    if (err != null) {
        console.log(err);
    }
});

app.listen(8000);

var refreshLoop = function () {

    connectionsDatas.forEach(function (client) {
        if (client.sensorId != undefined && client.sensorLastDate != undefined) {
            var query = connection.query("SELECT * FROM measurements WHERE sensor_id = '" + client.sensorId + "' AND created_at > '" + client.sensorLastDate + "'"),
                measurements = [];

            query.on('error', function (err) {
                console.log(err);
                update(err);
            })
                .on('result', function (measurement) {
                    measurements.push(measurement);
                    client.sensorLastDate = new Date(measurement.created_at).toMysqlFormat();
                })
                .on('end', function () {
                    if (measurements.length > 0) {
                        update(client.socket, {measurements: measurements});
                    }
                })
        }
    });

    if (connectionsArray.length) {
        refreshTimer = setTimeout(refreshLoop, REFRESH_INTERVAL);
    }
};

io.sockets.on('connection', function (socket) {
    console.log('A new socket is connected');
    connectionsArray.push(socket);

    if (connectionsArray.length) {
        refreshLoop();
    }

    socket.on('data', function (data) {
        connectionsDatas.push({
            "socket": socket,
            "sensorId": data.id,
            "sensorLastDate": data.date
        });
    });

    socket.on('disconnect', function () {
        var index = connectionsArray.indexOf(socket);
        console.log('socket = ' + index + 'disconnected');
        if (index >= 0) {
            connectionsArray.splice(index, 1);
            for (i = 0; i < connectionsDatas.length; i++) {
                if (connectionsDatas[i].socket == socket) {
                    connectionsDatas.splice(index, 1);
                }
            }
        }
    });
});

var update = function (socket, data) {
    data.time = new Date();
    socket.emit('notification', data);
};

/* Utils */
function twoDigits(d) {
    if (0 <= d && d < 10) return "0" + d.toString();
    if (-10 < d && d < 0) return "-0" + (-1 * d).toString();
    return d.toString();
}

Date.prototype.toMysqlFormat = function () {
    return this.getFullYear() + "-" + twoDigits(1 + this.getMonth()) + "-" + twoDigits(this.getDate()) + " " + twoDigits(this.getHours()) + ":" + twoDigits(this.getMinutes()) + ":" + twoDigits(this.getSeconds());
};
