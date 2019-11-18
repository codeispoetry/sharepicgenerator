module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),
      uglify: {
        build: {
          src: 'build/js/*.js',
          dest: 'htdocs/js/main.min.js'
        }
      },
      sass: {
        dev: {
          files: {
            'htdocs/css/styles.css':'build/scss/main.scss'
          }
        }
      },
      watch: {
        css: {
          files: 'build/scss/**/*.scss',
          tasks: ['sass']
        },
        js: {
          files: 'build/js/**/*.js',
          tasks: ['uglify']
        },
      },
    });

    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');



    // Default task(s).
    grunt.registerTask('default', ['watch']);

    grunt.registerTask('build', ['uglify','sass']);

  };
