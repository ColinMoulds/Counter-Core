<p align="center"><img width=80% src="https://github.com/ColinMoulds/Counter-Core/blob/master/Media/logo.png"></p>

[![Build Status](https://img.shields.io/badge/build-passed-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core/tree/master/Application)
[![Dependencies](https://img.shields.io/badge/dependencies-up%20to%20date-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core#prerequisites)
[![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core/graphs/contributors)
[![License](https://img.shields.io/badge/license-MIT%20License-brightgreen.svg)](https://opensource.org/licenses/MIT)

# Counter Core Deposit & Withdraw Addon

In this repository resides the core script addon for Deposit & Withdrawl.

## Getting Started

You will need to deploy the main system which can be found [Counter Core](https://github.com/ColinMoulds/Counter-Core).

### Deployment

Upload/Execute the provided SQL file on your database.

Click on SQL in the topmenu and add the following commands and click on “Ok”: 

ALTER TABLE  users ADD  deposited INT NOT NULL DEFAULT  '0'; 

ALTER TABLE  users ADD  withdrawLimit INT NOT NULL DEFAULT  '0'; 
 
Drag & drop the Steambot folder into the directory "/var/www" 
 
Drag & drop all other folders and files into the directory "/var/www/html"

Run the following commands in order in your terminal:

```
cd /var/www/html 
mkdir cache 
sudo chown www-data cache 
sudo apt-get install libcurl 
sudo apt-get install php5-curl 
cd /var/www/steambot 
npm install steamcommunity 
npm install steam-totp 
npm install mysql 
npm install log4js 
npm install steam-tradeoffers 
npm install async 
npm install request 
npm install steam 
npm install fs 
npm install express 
npm install express-ipfilter 
npm install forever -g
```

Open bot.js and enter your MySQL Credentials. 

Open bot_manager.js and enter your MySQL credentials.

 Open your user-information.php file and add these lines right before "if(!$as)":

```
$canWithdraw = fetchinfo("canWithdraw","users","steamid",$_SESSION["steamid"]); 
$withdrawLimit = fetchinfo("withdrawLimit","users","steamid",$_SESSION["steamid"]); 
$steamid = $_SESSION["steamid"]; 
$user = $steamid; 
$deposited = fetchinfo("deposited","users","steamid",$_SESSION["steamid"]); 
```

Open bot-core.php and change line 3 to your database credentials

Now change $priceslocation in bot-core.php to your bots folder
(For example, if bot.js was located in /var/www/steambot it would be "/var/www/steambot/prices.txt". If it was in /var/www/server, it would be "/var/www/server/prices.txt")

Type “sudo nano /etc/php5/apache2/php.ini”. 
Now find “short_open_tag=Off”. 
Change it to “short_open-tag=On”. 
Now press CTRL + X and save.
Run “sudo service apache2 restart”.

You can change the min. deposit in bot-core.php by changing the variable $min. This is in Credits, NOT in $.

Open bot.js and change the string in "var sitename" to your websites name or URL (this will appear in your trade offers!) 

Make an ApiKey on backpack.tf (https://backpack.tf/api/register)

Now go into the database, go to the bots table and fill out your info.

After you fill out your info, run "cd /var/www/steambot".

To turn on the bot, run "forever start bot_manager.js"

## Built With

* [Node](https://github.com/nodejs/node/blob/master/README.md) - JavaScript Web Runtime
* [Npm](https://github.com/npm/npm) - Package Managemer

## Authors

*Initial work* - [Colin Moulds](https://github.com/ColinMoulds)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE.md) file for details

## Acknowledgments

* Hat tip to anyone who's code was used
* Inspiration
* Coffee