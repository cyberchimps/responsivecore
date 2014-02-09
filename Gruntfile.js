module.exports = function(grunt) {

  grunt.initConfig({
    cssmin: {
      add_banner: {
        options: {
          //banner: '/* Theme Name: Responsive Author: CyberChimps.com Version: 1.9.4.9 Text Domain: responsive */'
        },
        files: {
          'css/style.min.css': ['css/style.css', 'css/responsive.css']
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-cssmin');

  //grunt.registerTask('default', ['jshint', 'qunit', 'concat', 'uglify']);

}
