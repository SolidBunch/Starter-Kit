const baseConfig = require('./_basic.config')();
const path = require('path');
const glob = require('glob');

const pathTo = path.resolve(__dirname + "/../") + '/core/shortcodes/';
//read all styles.scss from shortcodes
const stylesArray = glob.sync(pathTo + '**/assets/style.scss');

let assetsObject = stylesArray.reduce((acc, item) => {
	let name = item.replace(pathTo, '');
	name = name.replace('/assets/style.scss', '');
	acc[name] = new Array(item);
	return acc;
}, {});

//read all scripts.js from shortcodes
const scriptsArray = glob.sync(pathTo + '**/assets/scripts.js');
scriptsArray.reduce((acc, item) => {

	let name = item.replace(pathTo, '');
	name = name.replace('/assets/scripts.js', '');
	if (Array.isArray(assetsObject[name]) === true) {
		assetsObject[name].push(item);
	} else {
		acc[name] = new Array(item);
	}
	return acc;
}, {});

// include the css extraction and minification plugins
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

baseConfig.plugins.push(
	new MiniCssExtractPlugin({
		filename: '[name]/assets/style.css'
	}));

baseConfig.output = {
	path: pathTo,
	filename: '[name]/assets/scripts.min.js'
};

module.exports = Object.assign(
	{
		name: 'shortcodes',
		entry: assetsObject,
	},
	baseConfig
);
