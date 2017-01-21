// console maba:webpack:dev-server
require('expose?$!expose?jQuery!jquery');

// Bootstrap & bootstrap-webpack
require('bootstrap');
require('bootstrap-webpack');

// AdminLTE, skins and font-awesome
require('admin-lte'); // 'admin-lte/dist/js/app.min.js'
require('admin-lte/build/less/AdminLTE.less');
require('admin-lte/build/less/skins/skin-green.less');

// Font Awesome
require('font-awesome/less/font-awesome.less');

// Other libs
require('holderjs');
require('jquery-slimscroll');

// Fastclick prevents the 300ms touch delay on touch devices
var attachFastClick = require('fastclick');
attachFastClick.attach(document.body);

console.log('All OK!!');