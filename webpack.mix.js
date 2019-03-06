const mix = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

let merge = require('babel-merge');

class BabelConfig {
    /**
     * Generate the appropriate Babel configuration for the build.
     *
     * @param {Object} mixBabelConfig
     * @param {String} babelRcPath
     */
    static generate(mixBabelConfig, babelRcPath) {
        return merge.all(
            [
                BabelConfig.default(),
                new BabelConfig().fetchBabelRc(babelRcPath),
                mixBabelConfig
            ],
            {
                arrayMerge: (destinationArray, sourceArray, options) =>
                    sourceArray
            }
        );
    }

    /**
     * Fetch the user's .babelrc config file, if any.
     *
     * @param {String} path
     */
    fetchBabelRc(path) {
        return File.exists(path) ? JSON.parse(File.find(path).read()) : {};
    }

    /**
     * Fetch the default Babel configuration.
     */
    static default() {
        return {
            cacheDirectory: true,
            presets: [
                [
                    '@babel/preset-env',
                    {
                        modules: false,
                        forceAllTransforms: true
                    }
                ]
            ],
            plugins: [
                '@babel/plugin-proposal-object-rest-spread',
                '@babel/plugin-syntax-dynamic-import',

                [
                    '@babel/plugin-transform-runtime',
                    '@babel/plugin-syntax-dynamic-import',
                    {
                        helpers: false
                    }
                ]
            ]
        };
    }
}

module.exports = BabelConfig;



mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');

