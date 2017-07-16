var SteamCommunity = require('steamcommunity');
var SteamTotp = require('steam-totp');
var mysql = require('mysql');
var log4js = require('log4js');
var SteamTradeOffers = require('steam-tradeoffers');
var async = require('async');
var request = require('request');
var fs = require('fs');

var ips = ['127.0.0.1', '::ffff:127.0.0.1']; //DO NOT CHANGE!!!!

var sitename = "YOURSITE.com";
var backpacktfApiKey = ""; //Put your backpack.tf api key in here! API key is found at https://backpack.tf/api/register

var pool  = mysql.createPool({
	connectionLimit : 10,
	database: 'DATABASE',
	host: 'localhost',
	user: 'USER',
	password: 'PASSWORD'
});

var community = new SteamCommunity();
var offers = new SteamTradeOffers();
log4js.configure({
	appenders: [
		{ type: 'console' },
		{ type: 'file', filename: 'logs/bot_'+process.argv[2]+'.log' }
	]
});

var logger = log4js.getLogger();
logger.trace("Thank you for purchasing Deposit & Withdraw by Graphite & Dulpy!");
function getPrices() {
	var prices;
	request('http://backpack.tf/api/IGetMarketPrices/v1/?key='+backpacktfApiKey+'&compress=1&appid=730', function(error, response, body) {
	prices = JSON.parse(body);
	if(prices.response.success == 1) {
        logger.warn('Loaded fresh prices');
        fs.writeFileSync('prices.txt', body);
        logger.trace('New prices loaded');
    }
	else{
		logger.warn("Error Loading Prices");
	}
	});
}
getPrices();
setInterval(function() {
        getPrices();
      }, 70000 );

var express = require('express'),
	ipfilter = require('express-ipfilter').IpFilter;
var app = express();
app.use(ipfilter(ips, {mode: 'allow'}));

module.exports = app;
app.get('/sendTradefdgdfhfghfyrt6456fgh456rtgh345456etgdfgdfg/', function (req, res) {
	var assetids = req.query['assetids'];
	assetids = assetids.split(',');
	var partner = req.query['partner'];
	var token = req.query['token'];
	var checksum = req.query['checksum'];
	var steamid = req.query['steamid'];
	var senditems = [];
	for(var i = 0; i < assetids.length; i++) {
		if(assetids[i] == "") continue;
		senditems.push({
			appid: 730,
			contextid: 2, 
			assetid: assetids[i]
		});
	}
	var code = makecode();
	console.log(partner, token, checksum, assetids, senditems);
	offers.makeOffer({
		partnerAccountId: partner,
		accessToken: token,
		itemsFromThem: senditems,
		itemsFromMe: [],
		message: 'Thank you for your deposit on '+sitename+'  (Code: '+code+')'
	}, function(err, r) {
		if(err) {
			logger.error('Error sending trade');
			logger.debug(err);
			res.json({
				success: false,
				error: err.toString()
			});
		} else {
			offers.loadPartnerInventory({
				partnerSteamId: steamid,
				tradeOfferId: r.tradeofferid,
				appId: 730,
				contextId: 2,
				language: 'russian'
			}, function(err, rr) {
				if(err) {
					logger.debug(err);
					res.json({
						success: false,
						error: err.toString()
					});
				} else {
					var names = [];
					for(var i = 0; i < senditems.length; i++) {
						for(var a = 0; a < rr.length; a++) {
							if((senditems[i].assetid == rr[a].id) && (!rr[a].ss)) {
								names.push({market_hash_name: rr[a].market_hash_name, icon_url: rr[a].icon_url});
								rr[a].ss = 1;
								continue;
							}
						}
					}
					res.json({
						success: true,
						code: code,
						amount: checksum,
						tid: r.tradeofferid,
						items: names
					});
				}
			});
		}
	});
});

app.get('/sendTradeMegdfghbkdfbgjhdfgdfshjfgdfkhjgdfjkgrd/', function (req, res) {
	var names = req.query['names'];
	names = names.split(',');
	var partner = req.query['partner'];
	var token = req.query['token'];
	var checksum = req.query['checksum'];
	offers.loadMyInventory({
		appId: 730,
		contextId: 2
	}, function(err, items) {
		if(err) {
			logger.error('Error sending trade');
			logger.debug(err);
			res.json({
				success: false,
				error: err.toString()
			});			
		} else {
			var senditems = [];
			for(var i = 0; i < names.length; i++) {
				for(var a = 0; a < items.length; a++) {
					if((names[i] == items[a].market_hash_name) && (!items[a].ss)) {
						senditems.push({
							appid: 730,
							contextid: 2, 
							assetid: items[a].id
						});
						if(senditems.length == names.length-1) break;
						items[a].ss = 1;
						continue;
					}
					if(senditems.length == names.length-1) break;
				}
			};
			var code = makecode();
			console.log(partner, token, checksum, names, senditems);
			offers.makeOffer({
				partnerAccountId: partner,
				accessToken: token,
				itemsFromThem: [],
				itemsFromMe: senditems,
				message: 'Thank you for using '+sitename+'!  (Code: '+code+')'
			}, function(err, r) {
				if(err) {
					logger.error('Error sending trade');
					logger.debug(err);
					res.json({
						success: false,
						error: err.toString()
					});
				} else {
					res.json({
						success: true,
						code: code,
						amount: -checksum,
						tid: r.tradeofferid,
						state: 2
					});
				}
			});
		}
	});
});

app.get('/checkTradedfkrnjhdfgjdngjkfdg/', function (req, res) {
	var tid = req.query['tid'];
	var typeTrade = req.query['typeTrade'];
	logger.trace(typeTrade);
	offers.getOffer({
		tradeofferid: tid,
		typeTrade: typeTrade
	}, function(err, trade) {
		if(err) {
			logger.error('Error checking trade');
			logger.debug(err);
			res.json({
				success: false,
				error: err.toString()
			});
		} else {
			logger.debug(trade);
			if(trade.response.offer.trade_offer_state == 3) {
				res.json({
					success: true,
					action: 'accept',
					result: 'Your balance has been changed! Thanks for using '+sitename
				});
			} else if(trade.response.offer.trade_offer_state == 7) {
				res.json({
					success: true,
					result: 'You declined the trade',
					action: 'cross',
					type: typeTrade
				});
			} else {
				res.json({
					success: false,
					error: 'You did not accept trade'
				});
			}
		}
	});
});

function cancelTrade(offerid) {
	offers.declineOffer({
		tradeOfferId: offerid
	}, function(err, log) {
		if (err) {
			logger.error('?? ?????? ???????? ????? #'+offerid);
			logger.debug(err);
			return;
		}
		logger.debug(log);
		logger.trace('Offer #'+offerid+' canceled');
	});
}

query('SELECT * FROM `bots` WHERE `id` = '+pool.escape(process.argv[2]), function(err, res) {
	if((err) || (!res[0])) {
		logger.error('Cant find account');
		process.exit(0);
		return;
	}
	account = res[0];
	app.listen(8967+account.id);
	logger.trace('We got account info');
	account.twoFactorCode = SteamTotp.generateAuthCode(account.shared_secret);
	account.auth = false;
	logger.debug(account);
	community.login(account, login);
});

community.on('confKeyNeeded', function(tag, callback) {
    callback(null, time, SteamTotp.getConfirmationKey(account.identity_secret, time(), tag));
});

community.on('newConfirmation', function(confirmation) {
	var time = time();
	var key = SteamTotp.getConfirmationKey(account.identity_secret, time, 'allow');
	confirmation.respond(time, key, true, function(err) {
		if(err) {
			logger.error('Error on mobile auth');
			logger.debug(err);
			return;
		}
		logger.trace('Trade sucesfully confirmed');
	});
});

function query(sql, callback) {
	if (typeof callback === 'undefined') {
		callback = function() {};
	}
	pool.getConnection(function(err, connection) {
		if(err) return callback(err);
		logger.info('DB connection ID: '+connection.threadId);
		connection.query(sql, function(err, rows) {
			if(err) return callback(err);
			connection.release();
			return callback(null, rows);
		});
	});
}

function login(err, sessionID, cookies, steamguard) {
	if(err) {
		logger.error('Auth error');
		logger.debug(err);
		if(err.message == "SteamGuardMobile") {
			account.twoFactorCode = SteamTotp.generateAuthCode(account.shared_secret);
			logger.warn('Error in auth: '+account.twoFactorCode);
			setTimeout(function() {
				community.login(account, login);
			}, 5000);
			return;
		}
		process.exit(0);
	}
	logger.trace('Sucesfully auth');
	account.sessionID = sessionID;
	account.cookies = cookies;
	community.getWebApiKey('csgoseason.com', webApiKey);
	community.startConfirmationChecker(10000, account.identity_secret);
}

function webApiKey(err, key) {
	if(err) {
		logger.error('Cant make apikey')
		logger.debug(err);
		process.exit(0);
		return;
	}
	account.key = key;
	logger.trace('API key bot '+account.accountName+' '+account.key);
	offersSetup();
	community.loggedIn(checkLoggedIn);
}

function offersSetup() {
	logger.trace('Loaded steam-tradeoffers');
	offers.setup({
		sessionID: account.sessionID,
		webCookie: account.cookies,
		APIKey: account.key
	});
}

function checkLoggedIn(err, loggedIn, familyView) {
	if((err) || (!loggedIn)) {
		logger.error('We arent logged in')
		process.exit(0);
	} else {
		logger.trace('Logged in');
		account.auth = true;
	}
}

function makecode() {
    var text = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for(var i=0; i < 5; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));

    return text;
}

function time() {
	return parseInt(new Date().getTime()/1000)
}

