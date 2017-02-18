const webpack = require('webpack');
const { join, resolve } = require('path');
const { getIfUtils, removeEmpty } = require('webpack-config-utils');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const AssetsPlugin = require('assets-webpack-plugin')
const ProgressBarPlugin = require('progress-bar-webpack-plugin');
const WriteFilePlugin = require('write-file-webpack-plugin');

module.exports = (env) => {
    const { ifProd, ifNotProd } = getIfUtils(env);

    return {
        context: resolve(__dirname, './app/Resources/assets'),
        devtool: ifProd('source-map', 'cheap-module-source-map'),
        entry: {
            main: './main.js'
        },
        output: {
            path: resolve(__dirname, './web'),
            filename: ifProd('js/[name].[hash].js', 'js/[name].js'),
            pathinfo: ifNotProd(), // Include comments with information about the modules.
        },
        resolve: {
            extensions: ['.js'],
        },
        module: {
            rules: [
                {
                    test: require.resolve('jquery'),
                    use: [
                        {
                            loader: 'expose-loader',
                            query: 'jQuery'
                        },
                        {
                            loader: 'expose-loader',
                            query: '$'
                        }
                    ]
                },
                {
                    // Do not transform vendor's CSS with CSS-modules
                    // The point is that they remain in global scope.
                    test: /\.css$/,
                    include: /node_modules/,
                    loader: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: {
                            loader: 'css-loader',
                            options: {
                                minimize: ifProd(),
                                sourceMap: true
                            }
                        }
                    })
                },
                {
                    test: /\.scss$/i,
                    loader: ExtractTextPlugin.extract({
                        fallback: 'style-loader',
                        use: [
                            {
                                loader: 'css-loader',
                                options: {
                                    minimize: ifProd(),
                                    sourceMap: true
                                }
                            }, {
                                loader: 'sass-loader'
                            }
                        ]
                    })
                },
                {
                    test: /\.(woff(2)?|eot|ttf|svg)(\?[a-z0-9=.]+)?$/,
                    use: 'file-loader?&publicPath=../fonts/&outputPath=fonts/&name=[name].[hash].[ext]'
                },
                {
                    test: /\.(gif|png|jpe?g|svg)$/i,
                    use: removeEmpty(
                        [
                            {
                                loader: 'url-loader',
                                query: {
                                    limit: 10 * 1000, // byte limit in bytes ( 10kb )
                                    hashType: 'sha512',
                                    digestType: 'hex',
                                    name: 'images/[name].[hash].[ext]',
                                }
                            },
                            ifProd(
                                {
                                    loader: 'image-webpack-loader',
                                    query: {
                                        progressive: true,
                                        optimizationLevel: 7,
                                        interlaced: false,
                                        pngquant: {
                                            quality: '65-90',
                                            speed: 4
                                        }
                                    }
                                }
                            )
                        ]
                    )
                },
            ]
        },
        plugins: removeEmpty([
            new webpack.LoaderOptionsPlugin({
                options: {
                    context: join(__dirname, 'web')
                }
            }),
            // write files to fs with webpack-dev-server
            new WriteFilePlugin(),
            new webpack.optimize.CommonsChunkPlugin({
                name: 'vendor',
                fileName: 'vendor.js',
                chunks: ['main'],
                minChunks: module => /node_modules\//.test(module.resource)
            }),
            new ExtractTextPlugin({
                filename: ifProd('css/[name].[contenthash].css', 'css/[name].css'),
                allChunks: true,
            }),
            ifProd(
                new AssetsPlugin({ path: join(__dirname, 'web', 'bundles') })
            ),
            ifProd(new webpack.optimize.UglifyJsPlugin({
                compress: {
                    screw_ie8: true,
                    warnings: false,
                },
                output: { comments: false }
            })),
            new ProgressBarPlugin(),
        ]),
    };
}
