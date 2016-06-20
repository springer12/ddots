var path = require('path'),
  fs = require('fs'),
  gUtil = require('gulp-util'),
  elixir = require('laravel-elixir'),
  resourcesFolder = 'resources',
  appName = gUtil.env.app && fs.statSync(appPath(gUtil.env.app)).isDirectory() ? gUtil.env.app : null,
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

// gentelella
  gentelella = {
      "css": vendorPath('gentelella/build/css/custom.css'),
      "js": vendorPath('gentelella/build/js/custom.js')
  },
/*
 * Apps resources
 */
  apps = {
      "frontend": {
          "fonts": [Bootstrap.fonts, appPath('frontend', 'fonts')],
          "css": [Bootstrap.css, appPath('frontend', 'css')],
          "js": [jQuery, Bootstrap.js, appPath('frontend', 'js')]
      },
      "backend": {
          "fonts": [Bootstrap.fonts, appPath('backend', 'fonts')],
          "css": [Bootstrap.css, /*gentelella.css,*/ appPath('backend', 'css')],
          "js": [jQuery, Bootstrap.js, /*gentelella.js,*/ appPath('backend', 'js')]
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
elixir(function(mix) {
    //mix.sass('app.scss');
    if (appName) {
        buildApp(mix, appName);
    } else {
        for (var app in apps) if (apps.hasOwnProperty(app)) {
            buildApp(mix, app);
        }
    }
});

function vendorPath(vPath, fromResource) {
    return path.join((fromResource ? resourcesFolder + '/vendor': 'vendor'), vPath);
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


function buildApp(mix, appName) {
    mix.copy(appFonts(appName), appFonts(appName, true));
    mix.copy(appMedia(appName), appMedia(appName, true));
    mix.styles(appCss(appName), appCss(appName, true), resourcesFolder);
    mix.scripts(appJs(appName), appJs(appName, true), resourcesFolder);
}