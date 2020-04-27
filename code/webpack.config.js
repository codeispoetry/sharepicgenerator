const path = require('path');
const ConcatPlugin = require('webpack-concat-plugin');


module.exports = (env = {}) => {
    return {
        mode: 'development',
        entry:[  path.resolve(__dirname, 'build/js/00init.js'), path.resolve(__dirname, 'build/scss/main.scss') ],
        output: {
            filename: 'js/main.min.js',
            path:  path.resolve(__dirname,"dist/assets/"),
        },
        plugins:[
            new ConcatPlugin({
                uglify: false,
                sourceMap: false,
                name: 'result',
                outputPath: "./js/",
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
                            options: {url: false}
                        },
                        {
                            loader: 'postcss-loader'
                        },
                        {
                            loader: 'sass-loader'
                        }
                    ]
                }
            ]
        }
    }
};


