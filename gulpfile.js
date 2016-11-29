var path = require('path'),
	fs = require('fs'),
	gUtil = require('gulp-util'),
	elixir = require('laravel-elixir'),
	args = require('yargs').argv,
	resourcesFolder = 'resources',
	appName = args.appName ? args.appName : gUtil.env.app && fs.statSync(appPath(gUtil.env.app)).isDirectory() ? gUtil.env.app : null,
	/*
	 * Vendor resources
	 */


// jQuery
	jQuery = vendorPath('jquery/dist/jquery.js'),

// Bootstrap
	Bootstrap = {
		"fonts": vendorPath('bootstrap/dist/fonts', true),
		"css": vendorPath('bootstrap/dist/css/bootstrap.css'),
		"js": vendorPath('bootstrap/dist/js/bootstrap.js')
	},

//glyphicons
	glyphs = {
		fonts: vendorPath('glyphicons/fonts', true),
		css: vendorPath('glyphicons/styles/glyphicons.css'),
	},

//mustache
	mustache = {
		js: vendorPath('mustache.js/mustache.js')
	},

// tether
	tether = {
		"css": vendorPath('tether/dist/css/tether.min.css'),
		"js": vendorPath('tether/dist/js/tether.min.js')
	},

	bootstrap_social = {
		"css": vendorPath('bootstrap-social/bootstrap-social.css')
	},

// gentelella
	gentelella = {
		"css": vendorPath('gentelella/build/css/custom.css'),
		"js": vendorPath('gentelella/build/js/custom.js')
	},

//font-awesome
	fontawesome = {
		"fonts": vendorPath('font-awesome/fonts', true),
		"css": vendorPath('font-awesome/css/font-awesome.min.css'),
	},

// eonasdan-bootstrap-datetimepicker
	datetimepicker = {
		"css": vendorPath('eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'),
		"js": vendorPath('eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')
	},


// bootstrap-checkbox
	select2 = {
		"css": vendorPath('select2/dist/css/select2.css'),
		"js": vendorPath('select2/dist/js/select2.js')
	},

	moment = {
		js: vendorPath('moment/min/moment-with-locales.js')
	},

//ace-builds code editor
	ace = vendorPath('ace-builds/src-min-noconflict', true),
	/*
	 * Apps resources
	 */
	apps = {
		"frontend": {
			"fonts": [Bootstrap.fonts, fontawesome.fonts, appPath('frontend', 'fonts')],
			"css": [tether.css, Bootstrap.css, bootstrap_social.css, fontawesome.css, datetimepicker.css, select2.css, appPath('frontend', 'css')],
			"js": [jQuery, tether.js, Bootstrap.js, moment.js, datetimepicker.js, select2.js, mustache.js, appPath('frontend', 'js')]
		},
		"backend": {
			"fonts": [Bootstrap.fonts, fontawesome.fonts, glyphs.fonts, appPath('backend', 'fonts')],
			"css": [tether.css, Bootstrap.css, select2.css, fontawesome.css, datetimepicker.css, gentelella.css, glyphs.css, appPath('backend', 'css')],
			"js": [jQuery, tether.js, select2.js, Bootstrap.js, gentelella.js, moment.js, datetimepicker.js, appPath('backend', 'js')]
		},
		"ace": {
			"js": [ace]
		}
	},
	outputExtPrefix = elixir.config.production ? '.min' : '';

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */
//@todo check build process
//@todo check watch feature
elixir(function (mix) {
	//mix.sass('app.scss');
	if (appName) {
		buildApp(mix, appName);
	} else {
		for (var app in apps)
			if (apps.hasOwnProperty(app)) {
				buildApp(mix, app);
			}
	}
});

function vendorPath(vPath, fromResource) {
	return path.join((fromResource ? resourcesFolder + '/vendor' : 'vendor'), vPath);
}

function appPath(appName, group) {
	return path.join(elixir.config.assetsPath, appName, group);
}

function publicPath(appName, group) {
	return path.join(elixir.config.publicPath, appName + '-bundle', group);
}

function appFonts(appName, out) {
	if (out) {
		return publicPath(appName, 'fonts');
	}

	return apps[appName].fonts;
}

function appMedia(appName, out) {
	if (out) {
		return publicPath(appName, 'media');
	}

	return appPath(appName, 'media');
}

function appCss(appName, out) {
	if (out) {
		return path.join(publicPath(appName, 'css'), 'bundle' + outputExtPrefix + '.css');
	}

	return apps[appName].css;
}

function appJs(appName, out) {
	if (out) {
		return path.join(publicPath(appName, 'js'), 'bundle' + outputExtPrefix + '.js');
	}

	return apps[appName].js;
}

function appAce(appName, out) {
	if (out) {
		return path.join(publicPath(appName, 'js'), 'ace');
	}

	return apps[appName].js;
}


function buildApp(mix, appName) {
	if (appName == 'frontend' || appName == 'backend') {
		mix.copy(appFonts(appName), appFonts(appName, true));
		mix.copy(appMedia(appName), appMedia(appName, true));
		mix.styles(appCss(appName), appCss(appName, true), resourcesFolder);
		mix.scripts(appJs(appName), appJs(appName, true), resourcesFolder);
	} else {
		mix.copy(appAce(appName), appAce(appName, true));
	}
}

var a = {
	"USER": "www-data",
	"HOME": "/var/www",
	"FCGI_ROLE": "RESPONDER",
	"SCRIPT_FILENAME": "/home/ddots/domains/ddots.org.ua/public/index.php",
	"QUERY_STRING": "",
	"REQUEST_METHOD": "GET",
	"CONTENT_TYPE": "",
	"CONTENT_LENGTH": "",
	"SCRIPT_NAME": "/index.php",
	"REQUEST_URI": "/ts/bot/",
	"DOCUMENT_URI": "/index.php",
	"DOCUMENT_ROOT": "/home/ddots/domains/ddots.org.ua/public",
	"SERVER_PROTOCOL": "HTTP/1.1",
	"GATEWAY_INTERFACE": "CGI/1.1",
	"SERVER_SOFTWARE": "nginx/1.4.6",
	"REMOTE_ADDR": "159.224.45.253",
	"REMOTE_PORT": "53006",
	"SERVER_ADDR": "93.190.42.61",
	"SERVER_PORT": "80",
	"SERVER_NAME": "ddots.org.ua",
	"REDIRECT_STATUS": "200",
	"HTTP_HOST": "ddots.org.ua",
	"HTTP_ACCEPT": "*/*",
	"HTTP_CONNECTION": "keep-alive",
	"HTTP_USER_AGENT": "python-requests/2.11.1",
	"HTTP_ACCEPT_ENCODING": "gzip, deflate",
	"HTTP_AUTHORIZATION": "Basic dmJveC0xLjI6eG9ibzJ2ZW4=",
	"PHP_SELF": "/index.php",
	"PHP_AUTH_USER": "vbox-1.2",
	"PHP_AUTH_PW": "xobo2ven",
	"REQUEST_TIME_FLOAT": 1480458091.8503,
	"REQUEST_TIME": 1480458091,
	"APP_ENV": "local",
	"APP_DEBUG": "true",
	"APP_KEY": "P0YdSCnch1nbE76Tipupv4jaYR6ElVzu",
	"APP_DOMAIN": "ddots.org.ua",
	"DB_CONNECTION": "mysql",
	"DB_HOST": "127.0.0.1",
	"DB_DATABASE": "dots",
	"DB_USERNAME": "root",
	"DB_PASSWORD": "susa123",
	"CACHE_DRIVER": "file",
	"SESSION_DRIVER": "file",
	"QUEUE_DRIVER": "sync",
	"REDIS_HOST": "127.0.0.1",
	"REDIS_PASSWORD": "null",
	"REDIS_PORT": "6379",
	"MAIL_DRIVER": "smtp",
	"MAIL_HOST": "mailtrap.io",
	"MAIL_PORT": "2525",
	"MAIL_USERNAME": "null",
	"MAIL_PASSWORD": "null",
	"MAIL_ENCRYPTION": "null",
	"GOOGLE_ID": "986055014558-d58gb9oo2tptvuunq1jevidakjd3j202.apps.googleusercontent.com",
	"GOOGLE_SECRET": "HmB7xmItqTUk6RuyhuZ5Fbo2",
	"GOOGLE_REDIRECT": "social/handle/google/",
	"FACEBOOK_ID": "1348007885213827",
	"FACEBOOK_SECRET": "78690b521f6991ec620375cb1bc56a1b",
	"FACEBOOK_REDIRECT": "social/handle/facebook/",
	"VKONTAKTE_ID": "5516113",
	"VKONTAKTE_SECRET": "RsKnn8YLbRSjXm8Pwtcf",
	"VKONTAKTE_REDIRECT": "social/handle/vkontakte/",
	"START_OF_TIME": "1466603612"
}


var b = {
	"USER": "www-data",
	"HOME": "/var/www",
	"FCGI_ROLE": "RESPONDER",
	"SCRIPT_FILENAME": "/home/ddots/domains/ddots.org.ua/public/index.php",
	"QUERY_STRING": "",
	"REQUEST_METHOD": "GET",
	"CONTENT_TYPE": "",
	"CONTENT_LENGTH": "",
	"SCRIPT_NAME": "/index.php",
	"REQUEST_URI": "/ts/bot/",
	"DOCUMENT_URI": "/index.php",
	"DOCUMENT_ROOT": "/home/ddots/domains/ddots.org.ua/public",
	"SERVER_PROTOCOL": "HTTP/1.1",
	"GATEWAY_INTERFACE": "CGI/1.1",
	"SERVER_SOFTWARE": "nginx/1.4.6",
	"REMOTE_ADDR": "159.224.45.253",
	"REMOTE_PORT": "53005",
	"SERVER_ADDR": "93.190.42.61",
	"SERVER_PORT": "80",
	"SERVER_NAME": "ddots.org.ua",
	"REDIRECT_STATUS": "200",
	"HTTP_HOST": "ddots.org.ua",
	"HTTP_USER_AGENT": "python-requests/2.11.1",
	"HTTP_CONNECTION": "keep-alive",
	"HTTP_ACCEPT_ENCODING": "gzip, deflate",
	"HTTP_ACCEPT": "*/*",
	"HTTP_AUTHORIZATION": "Basic dmJveC0xLjI6eG9ibzJ2ZW4=",
	"PHP_SELF": "/index.php",
	"PHP_AUTH_USER": "vbox-1.2",
	"PHP_AUTH_PW": "xobo2ven",
	"REQUEST_TIME_FLOAT": 1480458091.607,
	"REQUEST_TIME": 1480458091,
	"APP_ENV": "local",
	"APP_DEBUG": "true",
	"APP_KEY": "P0YdSCnch1nbE76Tipupv4jaYR6ElVzu",
	"APP_DOMAIN": "ddots.org.ua",
	"DB_CONNECTION": "mysql",
	"DB_HOST": "127.0.0.1",
	"DB_DATABASE": "dots",
	"DB_USERNAME": "root",
	"DB_PASSWORD": "susa123",
	"CACHE_DRIVER": "file",
	"SESSION_DRIVER": "file",
	"QUEUE_DRIVER": "sync",
	"REDIS_HOST": "127.0.0.1",
	"REDIS_PASSWORD": "null",
	"REDIS_PORT": "6379",
	"MAIL_DRIVER": "smtp",
	"MAIL_HOST": "mailtrap.io",
	"MAIL_PORT": "2525",
	"MAIL_USERNAME": "null",
	"MAIL_PASSWORD": "null",
	"MAIL_ENCRYPTION": "null",
	"GOOGLE_ID": "986055014558-d58gb9oo2tptvuunq1jevidakjd3j202.apps.googleusercontent.com",
	"GOOGLE_SECRET": "HmB7xmItqTUk6RuyhuZ5Fbo2",
	"GOOGLE_REDIRECT": "social/handle/google/",
	"FACEBOOK_ID": "1348007885213827",
	"FACEBOOK_SECRET": "78690b521f6991ec620375cb1bc56a1b",
	"FACEBOOK_REDIRECT": "social/handle/facebook/",
	"VKONTAKTE_ID": "5516113",
	"VKONTAKTE_SECRET": "RsKnn8YLbRSjXm8Pwtcf",
	"VKONTAKTE_REDIRECT": "social/handle/vkontakte/",
	"START_OF_TIME": "1466603612"
}
