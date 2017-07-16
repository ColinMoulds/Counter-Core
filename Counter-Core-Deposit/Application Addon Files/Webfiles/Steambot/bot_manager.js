var forever = require('forever-monitor');
var mysql = require('mysql');

var pool  = mysql.createPool({
	connectionLimit : 10,
	database: 'DATABASE',
	host: 'localhost',
	user: 'USER',
	password: 'PASSWORD'
});

query('SELECT * FROM `bots`', function(err, row) {
	if((err) || (!row.length)) {
		console.log('Failed request or empty bot table');
		console.log(err);
		return process.exit(0);
	}
	console.log('List of bots:');
	row.forEach(function(itm) {
		console.log('Launching bot# '+itm.id);
		var bot = new (forever.Monitor)('bot.js', {
			args: [itm.id]
		});
		bot.on('start', function(process, data) {
			console.log('Bot with ID '+itm.id+' started');
		});
		bot.on('exit:code', function(code) {
   			console.log('Bot stopped with code '+code);
		});
		bot.on('stdout', function(data) {
			console.log(data);
		});
		bot.start();
	});
});

function query(sql, callback) {
	if (typeof callback === 'undefined') {
		callback = function() {};
	}
	pool.getConnection(function(err, connection) {
		if(err) return callback(err);
		console.info('Database connection ID: '+connection.threadId);
		connection.query(sql, function(err, rows) {
			if(err) return callback(err);
			connection.release();
			return callback(null, rows);
		});
	});
}