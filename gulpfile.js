var elixir = require('laravel-elixir');

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

/*elixir(function(mix) {
    mix.sass('app.scss');
});*/
/*
elixir(function(mix) {
    mix.styles([
        "/../../../public/css/main.css",
        "/../../../public/css/bootstrap-combobox/css/bootstrap-combobox.css",
        "/../../../public/assets/css/bootstrap-datepicker3.css",
        "/../../../public/assets/css/bootstrap-datepicker3.standalone.css",
        "/../../../public/assets/jquery-ui/jquery-ui.css",
        "/../../../public/assets/jquery-ui/jquery-ui.structure.css",
        "/../../../public/assets/jquery-ui/jquery-ui.theme.css",
    ], 'public/css/all.css');
});*/

elixir(function(mix) {
    mix.scripts([
        "/../../../public/css/bootstrap-combobox/js/bootstrap-combobox.js",
        "/../../../public/assets/jquery-ui/jquery-ui.js"
    ]);
});