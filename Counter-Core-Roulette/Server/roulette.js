/*
   _____                     _  _   ___    __ __ 
  / ____|                   | || | / _ \  / //_ |
 | |  __  ___ _ __ __ _  ___| || || (_) |/ /_ | |
 | | |_ |/ _ \ '__/ _` |/ _ \__   _\__, | '_ \| |
 | |__| |  __/ | | (_| | (_) | | |   / /| (_) | |
  \_____|\___|_|  \__, |\___/  |_|  /_/  \___/|_|
                   __/ |                         
                  |___/                          
			
			
The CSGO.Network V3 was made by Gregory Steam (Gergo4961) and is the property of CSGO.Network.
If you need any special site/bot customization you can reach me on Steam!

Please note that I do not provide support for CSGO.Network, so do not contact me about Bot / Website errors.

http://steamcommunity.com/id/gergo4961/

Current version: V3.1
*/	

var mysql = require('mysql');
var log4js = require('log4js');
var io = require('socket.io')(2986);
var request = require('request');
var fs = require('fs');
var md5 = require('md5');
var sha256 = require('sha256');
var math = require('mathjs');
var request = require('request');
var sitepath = "176.63.145.229/projects/csgoresorts/05"; // No need to edit this

log4js.configure({
	appenders: [
		{ type: 'console' },
		{ type: 'file', filename: 'logs/site.log' }
	]
});
var logger = log4js.getLogger();

var pool  = mysql.createPool({
	connectionLimit : 10,
	database: 'csgjp',
	host: 'localhost',
	user: 'root',
	password: ''
});

process.on('uncaughtException', function (err) {
 logger.trace('Strange error');
 logger.debug(err);
});

/* */
var accept = 30;
var wait = 10; 
var br = 3; 
var chat = 2; 
var chatb = 2000000; 
var maxbet = 1000; 
var minbet = 25; 
var q1 = 2; 
var q2 = 14; 
var timer = -1; 
var users = {}; 
var roll = 0; 
var currentBets = [];
var historyRolls = []; 
var usersBr = {};
var usersAmount = {}; 
var currentSums = {
	'0-0': 0,
	'1-7': 0,
	'8-14': 0
};
var currentRollid = 0;
var pause = false;
var hash = ''; 
var last_message = {};
/* */

load();

function isNumeric(n){
  return (typeof n == "number" && !isNaN(n));
}

var prices;
request('http://backpack.tf/api/IGetMarketPrices/v1/?key=56fce4a5c4404545131c8fcf&compress=1&appid=730', function(error, response, body) {
	prices = JSON.parse(body);
	if(prices.response.success == 0) {
        logger.warn('Loaded fresh prices');
        if(fs.existsSync(__dirname + '/prices.txt')){
            prices = JSON.parse(fs.readFileSync(__dirname + '/prices.txt'));
            logger.warn('Prices loaded from cache');
        } else {
        	logger.error('No prices in cache');
            process.exit(0);
        }
    } else {
        fs.writeFileSync('prices.txt', body);
        logger.trace('New prices loaded');
    }
});

function generateHash()
{
	var url = 'http://'+sitepath+'/hashupdatersuperscript.php';
	request(url, function(error, response, body)
	{
		if(error)
		{
			console.log(error);
			return;
		}
	});
}
/*setInterval(function () No longer used but I did not want to delete this alltogether
{
    generateHash();
}, 120000);*/

updateHash();
function updateHash() {
	query('SELECT * FROM `hash` ORDER BY `id` DESC LIMIT 1', function(err, row) {
		if(err) {
			logger.error('Cant get the hash, stopping');
			logger.debug(err);
			process.exit(0);
			return;
		}
		if(row.length == 0) {
			logger.error('Wrong hash found, stopping');
			process.exit(0);
		} else {
			if(hash != row[0].hash) logger.warn('Loaded hash'+row[0].hash);
			hash = row[0].hash;
		}
	});
}

io.on('connection', function(socket) {
	var user = false;
	socket.on('hash', function(hash) {
		console.log(hash);
		query('SELECT * FROM `users` WHERE `account_secret` = '+pool.escape(hash), function(err, row) {
			if((err) || (!row.length)) return socket.disconnect();
			console.log('connection?');
			user = row[0];
			users[user.steamid] = {
				socket: socket.id
			}
			socket.emit('message', {
				accept: accept,
				balance: row[0].credits,
				br: br,
				chat: chat,
				chatb: chatb,
				count: timer-wait,
				icon: row[0].avatar,
				maxbet: maxbet,
				minbet: minbet,
				name: row[0].name,
				rank: row[0].admin,
				rolls: historyRolls,
				type: 'hello',
				user: row[0].steamid
			});
			currentBets.forEach(function(itm) {
				socket.emit('message', {
					type: 'bet',
					bet: {
						amount: itm.amount,
						betid: itm.betid,
						icon: itm.icon,
						lower: itm.lower,
						name: itm.name,
						rollid: itm.rollid,
						upper: itm.upper,
						user: itm.user,
						won: null
					},
					sums: {
						0: currentSums['0-0'],
						1: currentSums['1-7'],
						2: currentSums['8-14'],
					}
				});
			});
		});
	});
	socket.on('mes', function(m) {
		if(!user) return;
		logger.debug(m);
		if(m.type == "bet") return setBet(m, user, socket);
		if(m.type == "balance") return getBalance(user, socket);
		if(m.type == "plus") return plus(user, socket);
	});
	socket.on('disconnect', function() {
		io.sockets.emit('message', {
			type: 'logins',
			count: Object.size(io.sockets.connected)
		});
		delete users[user.steamid];
	})
});

function plus(user, socket) {
	query('SELECT * FROM `users` WHERE `steamid` = '+pool.escape(user.steamid), function(err, row) {
		if(err) return;
		if(time() > row[0].plus) {
			query('UPDATE `users` SET `plus` = '+pool.escape(time()+10*60)+', `credits` = `credits` + 1 WHERE `steamid` = '+user.steamid);
			socket.emit('message', {
				type: 'alert',
				alert: 'Confirmed'
			});
			getBalance(user, socket);
		} else {
			socket.emit('message', {
				type: 'alert',
				alert: 'You have '+(row[0].plus-time())+' to accept'
			});			
		}
	});
}

function getBalance(user, socket) {
	query('SELECT `credits` FROM `users` WHERE `steamid` = '+pool.escape(user.steamid), function(err, row) {
		if((err) || (!row.length)) {
			logger.error('Failed to load your balance');
			logger.debug(err);
			socket.emit('message', {
				type: 'error',
				enable: true,
				error: 'Error: You are not DB.'
			});
			return;
		}
		socket.emit('message', {
			type: 'balance',
			balance: row[0].credits
		});
		if(user.steamid) users[user.steamid].credits = parseInt(row[0].credits);
	})
}

function setBet(m, user, socket) {
	if((usersBr[user.steamid] !== undefined) && (usersBr[user.steamid] == br)) {
		socket.emit('message', {
			type: 'error',
			enable: true,
			error: 'You\'ve already placed '+usersBr[user.steamid]+'/'+br+' bets this roll.'
		});
		return;
	}
	
	if(!isNumeric(m.amount))
	{
		logger.warn('Damn Russian Hackers!');
		return;
	}
	
	if((m.amount < minbet) || (m.amount > maxbet)) {
		socket.emit('message', {
			type: 'error',
			enable: true,
			error: 'Invalid bet amount.'

		});
		return;
	}
	if(pause) {
		socket.emit('message', {
			type: 'error',
			enable: false,
			error: 'Betting for this round is closed.'
		});
		return;
	}
	    if(m.upper - m.lower > 6){
            logger.warn("User tried to place an invalid bid!! (Might be hacking)");
            return;
        } else {
            if(m.lower != 0 && m.lower != 1 && m.lower != 8){
                logger.warn("User is trying some weird offset!! (Might be hacking)");
                return;
            }
            if(m.lower == 0){
                m.upper = 0;
            } else {
                m.upper = m.lower + 6;
            }
        }
	var start_time = new Date();
	query('SELECT `credits` FROM `users` WHERE `steamid` = '+pool.escape(user.steamid), function(err, row) {
		if((err) || (!row.length)) {
			logger.error('Failed to find DB');
			logger.debug(err);
			socket.emit('message', {
				type: 'error',
				enable: true,
				error: 'You are not DB'
			});
			return;
		}
		if(row[0].credits >= m.amount) {
			query('UPDATE `users` SET `credits` = `credits` - '+parseInt(m.amount)+' WHERE `steamid` = '+pool.escape(user.steamid), function(err2, row2) {
				if(err2) {
					logger.error('Error in withdraw');
					logger.debug(err);
					socket.emit('message', {
						type: 'error',
						enable: true,
						error: 'You dont have enough points'
					});
					return;
				}
				query('INSERT INTO `bets` SET `user` = '+pool.escape(user.steamid)+', `amount` = '+pool.escape(m.amount)+', `lower` = '+pool.escape(m.lower)+', `upper` = '+pool.escape(m.upper), function(err3, row3) {
					if(err3) {
						logger.error('Error in DB');
						logger.debug(err);
						return;
					}
					getBalance(user, socket); // new
					var end = new Date();
					if(usersBr[user.steamid] === undefined) {
						usersBr[user.steamid] = 1;
					} else {
						usersBr[user.steamid]++;
					}
					if(usersAmount[user.steamid] === undefined) {
						usersAmount[user.steamid] = {
							'0-0': 0,
							'1-7': 0,
							'8-14': 0
						};
					}
					usersAmount[user.steamid][m.lower+'-'+m.upper] += parseInt(m.amount);
					currentSums[m.lower+'-'+m.upper] += m.amount;
					socket.emit('message', {
						type: 'betconfirm',
						bet: {
							betid: row3.insertId,
							lower: m.lower,
							upper: m.upper,
							amount: usersAmount[user.steamid][m.lower+'-'+m.upper]
						},
						credits: row[0].credits-m.amount,
						mybr: usersBr[user.steamid],
						br: br,
						exec: (end.getTime()-start_time.getTime()).toFixed(3)
					});
					users[user.steamid].credits = row[0].credits-m.amount;
					io.sockets.emit('message', {
						type: 'bet',
						bet: {
							amount: usersAmount[user.steamid][m.lower+'-'+m.upper],
							betid: row3.insertId,
							icon: user.avatar,
							lower: m.lower,
							name: user.name,
							rollid: currentRollid,
							upper: m.upper,
							user: user.steamid,
							won: null
						},
						sums: {
							0: currentSums['0-0'],
							1: currentSums['1-7'],
							2: currentSums['8-14'],
						}
					});
					currentBets.push({
						amount: m.amount,
						betid: row3.insertId,
						icon: user.avatar,
						lower: m.lower,
						name: user.name,
						rollid: currentRollid,
						upper: m.upper,
						user: user.steamid,
					});
					logger.debug('Bet #'+row3.insertId+' Ammount: '+m.amount);
					checkTimer();
				})
			});
		} else {
			socket.emit('message', {
				type: 'error',
				enable: true,
				error: 'You dont have any money'
			});
		}
	});
}

function checkTimer() {
	if((currentBets.length > 0) && (timer == -1) && (!pause)) {
		logger.trace('Timer starting');
		timer = accept+wait;
		timerID = setInterval(function() {
			logger.trace('Timer: '+timer+' Site timer: '+(timer-wait));
			if (timer == wait) {
				pause = true;
				logger.trace('Pause included');
				var inprog = getRandomInt(0, (currentBets.length/4).toFixed(0));
				io.sockets.emit('message', {
					type: 'preroll',
					totalbets: currentBets.length-inprog,
					inprog: inprog,
					sums: {
						0: currentSums['0-0'],
						1: currentSums['1-7'],
						2: currentSums['8-14'],
					}
				});
			}
			if (timer == wait-2) {
				logger.trace('Timer: ');
				toWin();
			}
			if(timer == 0) {
				logger.trace('Reset');
				timer = accept+wait;
				currentBets = [];
				historyRolls.push({id: currentRollid, roll: roll});
				if(historyRolls.length > 10) historyRolls.slice(1);
				usersBr = {};
				usersAmount = {};
				currentSums = {
					'0-0': 0,
					'1-7': 0,
					'8-14': 0
				};
				currentRollid = currentRollid+1;
				pause = false;
			}
			timer--;
		}, 1000);
	}
}

function toWin() 
{
	method=1; // Change this to 1 or 2 change the method it uses to get the winner, 2 might be unstable, unfair at the moment
	
	var sh = sha256(hash+'-'+currentRollid);
	/*roll = sh.substr(0, 8);
	roll = parseInt(roll, 16);
	roll = math.abs(roll) % 15;*/
	
	// Simple, easy way to choose a winner: Randoms a number between 0-14
	if(method==1)
	{
		roll=math.random(0, 14); 
		roll=math.floor(roll);
	}
	
	// Chances of getting a 0/Green are way smaller with this method, might be too hard and it will be changed, who knows:
	
	if(method==2)
	{
		roll=math.random(0, 145);
		roll=math.floor(roll);
		console.log(roll);
		if(roll==0)
		{
			roll=0;
		}
		if(roll>0 && roll<11) // 1-10
		{
			roll=1;
		}
		if(roll>10 && roll<21) // 11-20
		{
			roll=2;
		}
		if(roll>20 && roll<31) // 21-30
		{
			roll=3;
		}
		if(roll>30 && roll<41) // 31-40
		{
			roll=4;
		}
		if(roll>40 && roll<51) // 41-50
		{
			roll=5;
		}
		if(roll>50 && roll<61) // 51-60
		{
			roll=6;
		}
		if(roll>60 && roll<71) // 61-70
		{
			roll=7;
		}
		if(roll>70 && roll<81) // 71-80
		{
			roll=8;
		}
		if(roll>80 && roll<91) // 81-90
		{
			roll=9;
		}
		if(roll>90 && roll<101) // 91-100
		{
			roll=10;
		}
		if(roll>100 && roll<111) // 101-110
		{
			roll=11;
		}
		if(roll>110 && roll<121) // 111-120
		{
			roll=12;
		}
		if(roll>120 && roll<131) // 121-130
		{
			roll=13;
		}
		if(roll>130 && roll<141) // 131-140
		{
			roll=14;
		}
		
	}
	
	logger.trace('Rolled '+roll);
	var r = '';
	var s = q1;
	var wins = {
		'0-0': 0,
		'1-7': 0,
		'8-14': 0
	}
	if(roll == 0) { r = '0-0'; s = q2; wins['0-0'] = currentSums['0-0']*s; }
	if((roll > 0) && (roll < 8)) { r = '1-7'; wins['1-7'] = currentSums['1-7']*s; }
	if((roll > 7) && (roll < 15)) { r = '8-14'; wins['8-14'] = currentSums['8-14']*s; }
	logger.debug(currentBets);
	logger.debug(usersBr);
	logger.debug(usersAmount);
	logger.debug(currentSums);
	for(key in users) {
		if(usersAmount[key] === undefined) {
			var credits = null;
			var won = 0;
		} else {
			var credits = parseInt(users[key].credits)+usersAmount[key][r]*s;
			var won = usersAmount[key][r]*s;
		}
		if (io.sockets.connected[users[key].socket]) io.sockets.connected[users[key].socket].emit('message', {
			credits: credits,
			count: accept,
			nets: [{
					lower: 0,
					samount: currentSums['0-0'],
					swon: wins['0-0'],
					upper: 0
				}, {
					lower: 1,
					samount: currentSums['1-7'],
					swon: wins['1-7'],
					upper: 7
				}, {
					lower: 8,
					samount: currentSums['8-14'],
					swon: wins['8-14'],
					upper: 14
				}
			],
			roll: roll,
			rollid: currentRollid+1,
			type: "roll",
			wait: wait-2,
			wobble: getRandomArbitary(0, 1),
			won: won
		});
	}
	var wontotal=0;
	var losttotal=0;
	var totalprofit=0;
	currentBets.forEach(function(itm) {
		if((roll >= itm.lower) && (roll <= itm.upper))
		{
			logger.debug('Rate #'+itm.betid+' sum '+itm.amount+' win '+(itm.amount*s));
			var wonamount=itm.amount*s;
			var profit=wonamount-itm.amount;
			wontotal=wontotal+profit;
			query('UPDATE `users` SET `credits` = `credits` + '+itm.amount*s+' WHERE `steamid` = '+pool.escape(itm.user));
			var action = "Won "+wonamount+" Credits on the Roulette (Profit: "+profit+")";
		}
		else
		{
			losttotal=losttotal+itm.amount;
			var action = "Lost "+itm.amount+" Credits on the Roulette";
		}
	});
	totalprofit=losttotal-wontotal;
	query('UPDATE `rolls` SET `roll` = '+pool.escape(roll)+', `hash` = '+pool.escape(hash)+', `time` = '+pool.escape(time())+', `won`="'+wontotal+'",`lost`="'+losttotal+'",profit="'+totalprofit+'" WHERE `id` = '+pool.escape(currentRollid));
	query('INSERT INTO `rolls` SET `roll` = -1');
	updateHash();
}
/* */
var tagsToReplace = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;'
};

function replaceTag(tag) {
    return tagsToReplace[tag] || tag;
}

function safe_tags_replace(str) {
    return str.replace(/[&<>]/g, replaceTag);
}
Object.size = function(obj) {
	var size = 0,
		key;
	for (key in obj) {
		if (obj.hasOwnProperty(key)) size++;
	}
	return size;
};
function getRandomInt(min, max) {
	return Math.floor(Math.random() * (max - min + 1)) + min;
}
function getRandomArbitary(min, max) {
	return Math.random() * (max - min) + min;
}

function query(sql, callback) {
	if (typeof callback === 'undefined') {
		callback = function() {};
	}
	pool.getConnection(function(err, connection) {
		if(err) return callback(err);
		logger.info('DB Connection ID: '+connection.threadId);
		connection.query(sql, function(err, rows) {
			if(err) return callback(err);
			connection.release();
			return callback(null, rows);
		});
	});
}
function load() {
	query('SET NAMES utf8');
	query('SELECT `id` FROM `rolls` ORDER BY `id` DESC LIMIT 1', function(err, row) {
		if((err) || (!row.length)) {
			logger.error('Cant get number from the last game');
			logger.debug(err);
			process.exit(0);
			return;
		}
		currentRollid = row[0].id;
		logger.trace('Roll '+currentRollid);
	});
	loadHistory();
	setTimeout(function() { io.listen(3009); }, 3000);
}
function loadHistory() {
	query('SELECT * FROM `rolls` ORDER BY `id` LIMIT 10', function(err, row) {
		if(err) {
			logger.error('Cant load betting history');
			logger.debug(err);
			process.exit(0);
		}
		logger.trace('Sucesfully updated history');
		row.forEach(function(itm) {
			if(itm.roll != -1) historyRolls.push(itm);
		});
	});
}

function time() {
	return parseInt(new Date().getTime()/1000)
}