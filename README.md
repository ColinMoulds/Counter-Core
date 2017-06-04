# Counter Core Script

In this repository resides the core script for a trade/gambling website for Counter Strike : Global Offensive.

## Getting Started

These instructions will get you a copy of the project up and running (Installation). 
See (Deployment) for notes on how to deploy the project on a live system.

### Prerequisites

What things you need to install the software

```
1GB RAM VPS
Ubuntu 14.04 x64 (recommended)
```
### Installation

Clone the repository & copy over the Application folder.

This is the Folder that contains all the necessary files for the system.

### Deployment

This is the part of the guide will help you deploy the system on a VPS.

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
#7.: Open js/script.js and add your server's domain there, with the correct port.
#8.: Open your server.js and edit all the details required.
#9.: Log in to your VPS console
#10.: cd /var/www/server
#11.: forever start server.js
```

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