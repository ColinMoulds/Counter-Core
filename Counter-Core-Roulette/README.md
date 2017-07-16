<p align="center"><img width=80% src="https://github.com/ColinMoulds/Counter-Core/blob/master/Media/logo.png"></p>

[![Build Status](https://img.shields.io/badge/build-passed-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core/tree/master/Application)
[![Dependencies](https://img.shields.io/badge/dependencies-up%20to%20date-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core#prerequisites)
[![Contributions Welcome](https://img.shields.io/badge/contributions-welcome-brightgreen.svg)](https://github.com/ColinMoulds/Counter-Core/graphs/contributors)
[![License](https://img.shields.io/badge/license-MIT%20License-brightgreen.svg)](https://opensource.org/licenses/MIT)

# Counter Core Roulette Addon

In this repository resides the core script roulette addon.

## Getting Started

You will need to deploy the main system which can be found [Counter Core](https://github.com/ColinMoulds/Counter-Core).

### Deployment

We need to assign account_secrets to all users, to do that you have to add a few things to some files.

Lets start with steamauth/steamauth.php, which can be found [Here](https://github.com/ColinMoulds/Counter-Core-Roulette/blob/master/File%20Changes/steamauth.php).

And you have to add a new function to your user-information.php, which can be found [Here](https://github.com/ColinMoulds/Counter-Core-Roulette/blob/master/File%20Changes/user-information.php).

Add the new MYSQL tables to your database installation from core in PHPMyAdmin.

Copy all the files from the Web folder to your server (/var/www/html).

Edit your topmenu.php and add a page for the roulette.

Copy the roulette.js to your server, configure it (mysql, port - sitepath is not needed atm)and run it first without using forever.js, simply node roulette.js to see any errors in case you've set it up wrong or you are missing the libraries. Check the required libraries below.

Open the roulette-content/js/new.js and set it up, add your server's IP or domain, port and you are ready to go.

Just bet 25 to get the script rolling on it's own (to avoid a visual bug) and that's it!

###Required libraries

( Be sure to be in the folder /var/www before you install NPM libraries )

```
npm install mysql
npm install log4js
npm install socket.io
npm install request
npm install node-fs (or npm install fs if it doesn't work)
npm install md5
npm install sha256
npm install mathjs
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