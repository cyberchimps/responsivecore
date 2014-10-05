module.exports = function(grunt) {

require('load-grunt-tasks')(grunt);

// Project configuration.
grunt.initConfig({
	pkg: grunt.file.readJSON('package.json'),
	uglify: {
		options: {
			mangle: false
		},
		build: {
				files: [
					{
						expand: true,     // Enable dynamic expansion.
						src: 'js-dev/*.js', // Actual pattern(s) to match.
						dest: '/js',
						rename: function (dest, src) {
							var filename = src.substring(src.lastIndexOf('/'), src.length);
							filename = filename.substring(0, filename.lastIndexOf('.'));
							return dest + filename + '.min.js';
						}
					},
			]
		}
	},

	csscomb: {
		dynamic_mappings: {
			expand: true,
			cwd: 'css/',
			src: ['*.css', '!*.min.css'],
			dest: 'css/',
			ext: '.css'
		}
	},

	cssmin: {
		add_banner: {
			options: {
				//banner: '/* Theme Name: Responsive Author: CyberChimps.com Version: 1.9.4.9 Text Domain: responsive */'
			},
			files: {
				'css/style.min.css': ['css/style.css', 'css/responsive.css']
			}
		}
	},

	checktextdomain: {
		options:{
			text_domain: 'responsive',
			correct_domain: true,
			keywords: [
				'__:1,2d',
				'_e:1,2d',
				'_x:1,2c,3d',
				'esc_html__:1,2d',
				'esc_html_e:1,2d',
				'esc_html_x:1,2c,3d',
				'esc_attr__:1,2d',
				'esc_attr_e:1,2d',
				'esc_attr_x:1,2c,3d',
				'_ex:1,2c,3d',
				'_n:1,2,4d',
				'_nx:1,2,4c,5d',
				'_n_noop:1,2,3d',
				'_nx_noop:1,2,3c,4d'
			]
		},
		files: {
			src:  [
				'**/*.php',
				'!**/class-tgm-plugin-activation.php',
				'!node_modules/**',
				'!build/**',
				'!**/*~'
			],
			expand: true
		}
	}

});

// Default task(s).
grunt.registerTask( 'default', [ 'uglify', 'cssmin'] );

};
