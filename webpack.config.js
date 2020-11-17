const webpackConfig = require('@nextcloud/webpack-vue-config')
const path = require('path')
const { merge } = require('webpack-merge')

const config = {
	entry: {
		main: path.join(__dirname, 'src', 'main.js'),
		dashboard: path.join(__dirname, 'src', 'dashboard.js'),
	},
}

module.exports = merge(webpackConfig, config)
