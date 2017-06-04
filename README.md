# Counter Core Script

In this repository resides the core script for a trade/gambling website for Counter Strike : Global Offensive.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software

```
1GB RAM VPS
Ubuntu 14.04 x64 (recommended)
```

### Installing

This is the part of the guide that will help you setup your LAMP enviroment for the software.

First we will start off with the commands.
```
sudo apt-get update 
sudo apt-get install apache2 
sudo apt-get install mysql-server php5-mysql 
sudo mysql_install_db 
sudo mysql_secure_installation 
apt-get install php5 libapache2-mod-php5 php5-mcrypt 
sudo apt-get install php5-curl 
sudo apt-get install php5-gd 
sudo service apache2 restart 
sudo apt-get install phpmyadmin

cd var/www/

curl -sL https://deb.nodesource.com/setup_4.x | sudo -E bash - 
sudo apt-get install -y nodejs
```

( Be sure to be in the folder /var/www before you install NPM libraries ) 

```
npm install http 
npm install socket.io 
npm install request 
npm install mysql 
npm install forever -g 
```

How to install the web application part of the system.
```
you have the same details on both places.   
#1.: Upload the .sql database through your PHPMyadmin.   
#2.: Upload the webfiles to your VPS. (/var/www or /var/www/html/) ~ Depending on version of Ubuntu
#3.: Edit link.php so it connects to your MYSQL database.   
#4.: Check core.php, edit the details required there.   
#5.: Go to your endround.php and set your rsecret.   
#6.: Go to steamauth/settings.php, set it up correctly.   
#7.: Open js/script.js and add your server's domain there, with the correct port. Please note: CloudFlare only allows certain ports.   
#8.: Open your server.js and edit all the details: the port it listents to, mysql information, sitepath, rsecret and other custom things.   
#9.: Log in to your VPS, navigate to your sever.js and run your server.js
     "node server.js" - > to test and see if it works, once it works we recommend using forever.js - > "forever start server.js"
```