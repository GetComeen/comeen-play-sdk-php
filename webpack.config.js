const alias = require("./webpack.alias");
const webpack = require('webpack');

module.exports = {
  output: {
    chunkFilename: 'js/[name].js?id=[chunkhash]',
  },
  resolve: {
    alias: Object.fromEntries(Object.entries(alias)
        .map(([key, path]) => [`@Domain/${key}`, path])),
    fallback: {
      "fs": false
    },
  },
  plugins: [
    new webpack.DefinePlugin({
      __VUE_OPTIONS_API__: false,
      __VUE_PROD_DEVTOOLS__: false,
    }),
  ],
}
