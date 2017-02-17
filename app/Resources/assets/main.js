require('expose-loader?$!expose-loader?jQuery!jquery');

// Bootstrap & bootstrap-webpack
require('bootstrap/dist/css/bootstrap.min.css');
require('bootstrap');

// AdminLTE, skins and font-awesome
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'
require('admin-lte/dist/css/AdminLTE.css');
require('admin-lte/dist/css/skins/skin-green.min.css');

// Font Awesome
require('font-awesome/css/font-awesome.min.css');

// Other libs
require('holderjs');
require('jquery-slimscroll');

require('./styles/main.scss');

// Fastclick prevents the 300ms touch delay on touch devices
var attachFastClick = require('fastclick');
attachFastClick.attach(document.body);

console.log('All OK!!');
