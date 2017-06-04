/*
  _____                   _              _____
 /  __ \                 | |            /  __ \
 | /  \/ ___  _   _ _ __ | |_ ___ _ __  | /  \/ ___  _ __ ___
 | |    / _ \| | | | '_ \| __/ _ \ '__| | |    / _ \| '__/ _ \
 | \__/\ (_) | |_| | | | | ||  __/ |    | \__/\ (_) | | |  __/
  \____/\___/ \__,_|_| |_|\__\___|_|     \____/\___/|_|  \___|

The Counter Core Script was made by Colin Moulds and is the property of A2 Development.
If you need any special site/bot customization you can reach us on Discord.

https://discord.gg/ydCsws7

Current version: 1.0
*/	

var server = require('http').createServer();
var io = require('socket.io')(server);
server.listen(8080);
var request = require('request');

var mysql = require('mysql');
var connection = mysql.createConnection({
	host     : 'localhost',
	user     : 'root',
	password : 'lolkek',
	database : 'csgjp',
	charset  : 'utf8_general_ci'
});

connection.connect();

var sitepath = ""; // Path to your website, without www or http:// | Example: counterscript.com
var JackpotTimer=120;
var playersRequired=2;
var endtimer = -1;
var disablecredits = -1;
var allowdeposits=1;
var mindeposit=25;
var maxdeposit=10000;
var rsecret='CHANGEME'; // Change this to the same thing you have in your Endround.php!

function DisableCreditBets()
{
	allowdeposits=0;
	io.emit('disablecredit');
}

function addslashes(str)
{
    str=str.replace(/\\/g,'\\\\');
    str=str.replace(/\'/g,'\\\'');
    str=str.replace(/\"/g,'\\"');
    str=str.replace(/\0/g,'\\0');
	return str;
}

function randomString(length, chars) 
{
    var mask = '';
    if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
    if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if (chars.indexOf('#') > -1) mask += '0123456789';
    if (chars.indexOf('!') > -1) mask += '~`!@#$%^&*()_+-={}[]:";\'<>?,./|\\';
    var result = '';
    for (var i = length; i > 0; --i) result += mask[Math.floor(Math.random() * mask.length)];
    return result;
}

function EndGame()
{
	endtimer = -1;
	proceedWinners();
	setTimeout(function()
	{
		io.emit('enablecredit');
		allowdeposits=1;
	},12000);
	
}

function ResumeJackpot()
{
	connection.query('SELECT `starttime` FROM `jackpotgames` GROUP BY `id` DESC', function(errs, rowss, fieldss)
	{
		if(errs)
		{
			return;
		}
		var timeleft;
		if(rowss[0].starttime == 2147483647)
		{
			timeleft = JackpotTimer;
		}
		else
		{
			var unixtime = Math.round(new Date().getTime()/1000.0);
			timeleft = rowss[0].starttime+JackpotTimer-unixtime;
			if(timeleft < 0)
			{
				timeleft = 0;
			}
		}
		if(timeleft != JackpotTimer)
		{
			endtimer = setTimeout(EndGame,timeleft*1000);
			console.log('[SERVER] Restoring the latest game with '+timeleft+' seconds left!');
		}
	});
}
ResumeJackpot();

function proceedWinners()
{
	console.log('[SERVER] Ending current game & choosing winner.');
	var url = 'http://'+sitepath+'/endround.php?secret='+rsecret+'';
	request(url, function(error, response, body)
	{
		if(error)
		{
			console.log('Couldn\'t end round, error: '+error);
			return;
		}
		if(response)
		{
			io.emit('jackpotanimation');
		}
	});	
}


io.on('connection', function (socket)
{

	console.log('connection');

	
	socket.on('jackpotanimation',function(status)
	{
		io.emit('jackpotanimation',status);
	});
	
	socket.on('showchat',function(status)
	{
		var data;
		try
		{
			data = JSON.parse(status);
		}
		catch (e)
		{
			return console.error(e);
		}
		status= JSON.parse(status);
		if(status.messageid && status.room>-1)
		{
			
			messageid=status.messageid;
			roomid=status.room;
			if(messageid>0 && roomid>-1)
			{
				connection.query('SELECT * FROM `chat` WHERE `id`='+connection.escape(messageid)+' ', function(err, row, fields)
				{
					if(row.length!=0)
					{
						part=row[0].PlayerID;
						var timenow=Math.round(new Date().getTime()/1000);
						started=row[0].time;
						since=timenow-started;

						if(since<5)
						{
							console.log('showchat');
							io.emit('showthechat',{ messageid: messageid, roomid: roomid });
						}
						else
						{
							console.log('timer');
						}
						
					}
					else
					{
						console.log('row lenght');
					}
				});
			}
			else
			{
				console.log('missing room  message');
			}
		}
		else
		{
			console.log('missing room or f message');
		}
	});
	
	socket.on('showmessages',function(status)
	{
		socket.emit('showthemessages',status);
	});
	socket.on('processdeposit',function(status)
	{
		
		if(allowdeposits==0)
		{
			return;
		}
		var data=status;
		data.steamid=addslashes(data.steamid);
		data.amount=addslashes(data.amount);
		data.secret=addslashes(data.secret);
		if(data.amount>=mindeposit && data.amount<=maxdeposit)
		{
			connection.query('SELECT * FROM `users` WHERE `steamid`="'+data.steamid+'"', function(err, row, fields)
			{
				var timenow=Math.round(new Date().getTime()/1000);
				updated=timenow+1;
				lastaction=row[0].lastaction;
				if(timenow<lastaction)		
				{
					return;
				}
				connection.query('UPDATE `users` SET `lastaction`="'+updated+'" WHERE `steamid`="'+data.steamid+'"', function(err, rows, fields)
				{
					if(row.length!=0)
					{
						var as=row[0].account_secret;
						var	ban=row[0].ban;
						var credits=row[0].credits;
						var steamname=row[0].name;
						if(steamname)
						{
							steamname=addslashes(steamname);	
						}
						var avatar=row[0].avatar;
						console.log(as);
						console.log(data.secret);
						if(as==data.secret)
						{
							if(ban==0)
							{
								if(credits>=data.amount)
								{
									connection.query('SELECT * FROM `jackpotgames` ORDER BY ID DESC LIMIT 1', function(err, row, fields)
									{
										var unixtime = Math.round(new Date().getTime()/1000.0);
										current=row[0].id;
										var timeleft;
										if(row[0].starttime == 2147483647)
										{
											timeleft = JackpotTimer;
										}
										else
										{
											timeleft = row[0].starttime+JackpotTimer-unixtime;
											if(timeleft < 0)
											{
												timeleft = 0;
											}
										}
										if(timeleft>5)
										{
											connection.query('UPDATE `users` SET `credits`=credits-'+data.amount+' WHERE `steamid`="'+data.steamid+'"', function(err, row, fields)
											{
												if(!err)
												{
													key=randomString(32, '#aA');
													connection.query('INSERT INTO `jackpotdeposits` (gameid,userid,username,useravatar,skin,cost,date,assetid,offerid) VALUES ("'+current+'","'+data.steamid+'","'+steamname+'","'+avatar+'","Credits","'+data.amount+'","'+unixtime+'","4961","'+key+'")', function(err, row, fields, result)
													{
														if(!err)
														{
															connection.query('UPDATE `jackpotgames` SET `value`=value+'+data.amount+', `skins`=skins+1 WHERE `id`="'+current+'"', function(err, row, fields)
															{

															});
															connection.query('SELECT COUNT(DISTINCT userid) AS playersCount FROM `jackpotdeposits` WHERE `gameid`=\''+current+'\'', function(err, rows)
															{  
																players = rows[0].playersCount;
																if(players == playersRequired && endtimer==-1)
																{
																		console.log('[SERVER] Starting the countdown for Game #'+current+'');
																		endtimer = setTimeout(EndGame,JackpotTimer*1000);
																		disablecredits = setTimeout(DisableCreditBets,115000);
																		connection.query('UPDATE `jackpotgames` SET `starttime`=UNIX_TIMESTAMP() WHERE `id` = \'' + current + '\'', function(err, row, fields) {});
																		io.emit('updategameinfo','');
																}
																else
																{
																	io.emit('showthedeposit',''+data.steamid+'/'+key+'');
																}
															});
														}
														else
														{
															console.log(err);
															return;
														}
														
														
													});
												}
											});
										}
										else
										{
											
										}
									});
				
									
								}
							}
						}
					}
				});
			});
		}
	});
	socket.on('showdeposit',function(status)
	{
		var array=status;
		io.emit('showthedeposit',status);
	});
	socket.on('updatecredits',function(status)
	{
		socket.emit('updatethecredits',status);
	});

});

function inArray(needle, haystack)
{
    var length = haystack.length;
    for(var i = 0; i < length; i++) 
	{
        if(haystack[i] == needle)
		{
            return true;
		}
    }
    return false;
}

setInterval(function ()
{
    connection.query('SELECT 1');
}, 3600000);

