const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const path = require('path');

module.exports = {
    context: __dirname, // Set the context to the current directory
  entry: './index.js', // Entry point for your project
  output: {
    filename: 'bundle.js',
    path: path.resolve(__dirname, 'dist'), // Output directory
  },
  module: {
    rules: [
      {
        test: /\.css$/, // Regular expression to match CSS files
        use: [
          MiniCssExtractPlugin.loader, // Extract CSS into files
          'css-loader', // Translates CSS into CommonJS
        ],
      },
    ],
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: 'styles.css', // Name of the output CSS file
    }),
  ],
  resolve: {
    // Optional: Add the 'HTML' directory to the resolve.modules array
    modules: [path.resolve(__dirname, 'HTML'), 'node_modules'],
  },
};
