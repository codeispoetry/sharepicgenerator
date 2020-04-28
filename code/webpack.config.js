const path = require('path');
const ConcatPlugin = require('webpack-concat-plugin');


module.exports = (env = {}) => {
    return {
        mode: 'development',
        devtool: 'source-map',
        entry:[  path.resolve(__dirname, 'build/scss/main.scss') ],
        output: {
            filename: 'js/main.min.js',
            path:  path.resolve(__dirname,"dist/assets/"),
        },
        plugins:[
            new ConcatPlugin({
                uglify: true,
                sourceMap: true,
                name: 'result',
                outputPath: "./js/",
                injectType: "none",
                fileName: 'main.bundled.js',
                filesToConcat: [ './build/js/*.js', './build/js/federal/*.js'],
                attributes: {
                    async: true
                }
            })
        ],
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
                            loader: 'postcss-loader'
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sourceMap: true
                            }
                        }
                    ]
                }
            ]
        }
    }
};


