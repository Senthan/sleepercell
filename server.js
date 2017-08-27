var app = require('http').createServer(handler);
var io = require('socket.io')(app);

require('dotenv').load();

io.set('origins', '*:80');

var Redis = require('ioredis');
var redis = new Redis();

var port = process.env.RT_SERVER_PORT || 6002;

app.listen(port, function() {
    console.log('Server is running in ' + port + ' port.');
});

function handler(req, res) {
    res.writeHead(200);
    res.end('');
}

redis.psubscribe('*', function(err, count) {
    //
});

redis.on('pmessage', function(subscribed, channel, message) {
    message = JSON.parse(message);
    console.log('Message received', channel, message.event);
    io.emit(channel + ':' + message.event, message.data);
});
