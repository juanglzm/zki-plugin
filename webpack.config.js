const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
	...defaultConfig,
	entry: {
		...defaultConfig.entry(),
		'zki-plugin-admin': [ path.resolve( __dirname, 'src/scripts/zki-plugin-admin.js' ) ],
		'zki-plugin-editor': [ path.resolve( __dirname, 'src/scripts/zki-plugin-editor.js' ) ],
		'zki-plugin-frontend': [ path.resolve( __dirname, 'src/scripts/zki-plugin-frontend.js' ) ],
	}
};
