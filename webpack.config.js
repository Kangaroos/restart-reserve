var entries = {};
var i = 0;

var env = process.env.NODE_ENV || "development";
var readYaml = require('read-yaml');

require('glob').sync('./resources/assets/!(vendor)/**/!(_)*.js').sort().forEach(function (file) {
    //console.log(file);
    entries[file.substr(22)] = file;
});
require('glob').sync('./resources/assets/!(vendor)/**/!(_)*.scss').sort().forEach(function (file) {
    //console.log(file);
    entries[file.substr(24) + ".js"] = file;
});

module.exports = options = {
    entry: entries,
    output: {
        publicPath: ("/assets/webpack/"),
        path: require('path').resolve(process.cwd() + "/public/assets/webpack"),
        filename: "[name]",
        chunkFilename: "[id].js"
    },
    module: {
        loaders: [
            {test: /\.dust$/, loader: "dust-loader"},
            {test: /\.css$/, loader: "style!css"},
            {
                test: /\.scss$/, loaders: [
                "style-loader",
                "css-loader?" + (config.minimize === false ? "-" : "+") + "minimize",
                "sass-loader?includePaths[]=" + require('path').resolve(__dirname, "./node_modules/bourbon-neat/app/assets/stylesheets/") + "&includePaths[]=" + require('path').resolve(__dirname, "./node_modules/bourbon/app/assets/stylesheets/"),
            ]
            },
            {test: /\.svg(\#.*)?$/, loader: "url?limit=1"},
            {test: /\.woff(\?v=\d+\.\d+\.\d+)?$/, loader: "url?limit=1&minetype=application/font-woff"},
            {test: /\.woff2(\?v=\d+\.\d+\.\d+)?$/, loader: "url?limit=1&minetype=application/font-woff"},
            {test: /\.ttf(\?v=\d+\.\d+\.\d+)?$/, loader: "url?limit=1&minetype=application/octet-stream"},
            {test: /\.eot(\?v=\d+\.\d+\.\d+)?$/, loader: "file"},
            {
                test: /\.(png|jpe?g)(\?.*)?$/,
                loader: "url?limit=1!image!image-maxsize" + (process.env.SKIP_MAXSIZE === "true" ? "?skip" : "")
            }
        ]
    },
    debug: true,
    resolve: {
        modulesDirectories: ["node_modules", "resources/assets", "resources/templates"]
    },
    externals: {
        "jquery": "jQuery",
        "io": "io",
        "dust": "dust",
        "moment": "moment",
        "lodash": "_",
        "hammerjs": "Hammer",
        "$script": "$script"
    }
};
var webpack = require('webpack');

options.plugins = options.plugins || [];
if (env === "production") {
    options.plugins.push(new webpack.optimize.UglifyJsPlugin({compress: {warnings: false}}));
}
