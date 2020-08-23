const path = require('path');
const fs = require('fs');
const ConcatPlugin = require('webpack-concat-plugin');
const isDevelopment = process.env.NODE_ENV === 'development';
const isProduction = process.env.NODE_ENV === 'production';
const tenants = [];

tenants.push(
    new ConcatPlugin({
        uglify: isProduction,
        sourceMap: isDevelopment,
        name: 'result',
        outputPath: "./js/",
        injectType: "none",
        fileName: 'main.min.js',
        filesToConcat: [ './build/js/*.js'],
        attributes: {
            async: true
        }
    })
);

const tenant_files = fs.readdirSync('./webpack.tenants/');
tenant_files.forEach(file => {
  if (path.extname(file) == ".js") {
    tenants.push(require('./webpack.tenants/' + file).tenant);
  }
});

module.exports = (env = {}) => {
    return {
        mode: 'development',
        devtool: (isDevelopment) ? 'source-map' : false,
        entry:[  path.resolve(__dirname, 'build/scss/main.scss') ],
        output: {
            filename: 'js/main.min.js',
            path:  path.resolve(__dirname,"dist/assets/"),
            sourceMapFilename: '[file].map'
        },
        plugins: tenants,
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: { }
                    }
                },
                {
                    test: /.scss$/,
                    use: [
                        {
                            loader: 'file-loader',
                            options: {
                                name: 'css/styles.css',
                                outputPath: './'
                            }
                        },
                        {
                            loader: 'extract-loader'
                        },
                        {
                            loader: 'css-loader',
                            options: {
                                url: false,
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'postcss-loader',
                            options: {
                                sourceMap: true
                            }
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true,
                                includePaths: [
                                    path.resolve(__dirname, 'build/scss/fallback')
                                ]
                            }
                        }
                    ]
                }
            ]
        }
    }
};
