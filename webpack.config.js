const path = require('path');
const fs = require('fs');
const webpack = require('webpack');
const TerserPlugin = require('terser-webpack-plugin');
const OptimizeCssAssetsPlugin = require("optimize-css-assets-webpack-plugin");
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const FixStyleOnlyEntriesPlugin = require("webpack-fix-style-only-entries");
const mode = (process.env.NODE_ENV == undefined) ? 'production' : process.env.NODE_ENV;
const devtool = (mode != 'production') ? 'source-map' : false;

// jsのバンドル設定
const exportScript = {
    mode,
    devtool,
    entry: path.resolve(__dirname, "src/Assets/js/admin.js"),
    output: {
        path: path.resolve(__dirname, 'webroot/js/vendor'),
        publicPath: '/js/vendor/',
        filename: 'bundle.js'
    },
    plugins: [
        new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            'window.jQuery': 'jquery',
            moment: "moment"
        })
    ],
    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                '@babel/preset-env',
                            ]
                        }
                    }
                ]
            }
        ]
    },
    performance: {
        hints: false
    }
};

// 各ページのjsファイル
const exportPageScripts = {
    mode,
    devtool,
    entry: {
    },
    output: {
        path: path.resolve(__dirname, 'webroot/js/admin'),
        publicPath: '/js/admin/',
        filename: '[name].js'
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                use: [
                    {
                        loader: 'babel-loader',
                        options: {
                            presets: [
                                '@babel/preset-env',
                            ]
                        }
                    }
                ]
            }
        ]
    },
    performance: {
        hints: false
    }
};
// src/Assets/js/admin以下のjsファイルをすべてエントリーポイントに追加
fs.readdirSync(path.resolve(__dirname, 'src/Assets/js/admin')).forEach(function(file) {
    if (file.endsWith('.js')) {
        exportPageScripts.entry[path.basename(file, '.js')] = path.join(__dirname, `src/Assets/js/admin/${file}`);
    }
});

// cssのバンドル設定
const exportStyle = {
    mode,
    devtool,
    entry: path.resolve(__dirname, "src/Assets/scss/style.scss"),
    output: {
        path: path.resolve(__dirname, 'webroot/css/vendor'),
        publicPath: '/css/vendor/',
        filename: 'bundle.js'
    },
    plugins: [
        new MiniCssExtractPlugin({
            filename: 'bundle.css'
        }),
        new OptimizeCssAssetsPlugin({
            cssProcessor: require('cssnano'),
            cssProcessorPluginOptions: {
                preset: [
                    'default',
                    {
                        discardComments: {
                            removeAll: true
                        }
                    }
                ]
            }
        }),
        // webroot/css/vendor/bundle.jsの生成を行わないようにするためのプラグイン設定
        new FixStyleOnlyEntriesPlugin()
    ],
    module: {
        rules: [
            {
                test: /\.(sa|sc|c)ss$/i,
                use: [
                    {
                        loader: MiniCssExtractPlugin.loader,
                    },
                    {
                        loader: 'css-loader',
                    },
                    {
                        loader: 'sass-loader',
                    },
                ],
            },
            {
                test: /\.(ttf|eot|svg|gif|woff|woff2)(\?v=[0-9]\.[0-9]\.[0-9])?$/,
                use: [
                    {
                        loader: 'file-loader'
                    }
                ]
            }
        ]
    },
    performance: {
        hints: false
    }
};

// jsバンドル、各ページのjs、cssバンドルの設定をexportsに追加
module.exports = [exportScript];
if (Object.keys(exportPageScripts.entry).length > 0) {
    module.exports.push(exportPageScripts);
}
module.exports.push(exportStyle);

// 本番モードのときjsバンドル、各ページのjsについて
// terser-webpack-pluginによるコメント削除、console.log削除等を実施
if (mode === 'production') {
    module.exports.forEach(function(exportConfig){
        if (exportConfig.output.publicPath != '/css/vendor/') {
            exportConfig.optimization = {
                minimize: true,
                minimizer: [
                    new TerserPlugin({
                        terserOptions: {
                            output: {
                                comments: false
                            },
                            compress: {
                                drop_console: true
                            }
                        }
                    })
                ]
            };
    	}
    });
}

//const util = require('util');
//console.log(util.inspect(module.exports, {showHidden: false, depth: null}));