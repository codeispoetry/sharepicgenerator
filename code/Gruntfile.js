module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
      pkg: grunt.file.readJSON('package.json'),
      uglify: {
        build: {
          src: 'source/js/*.js',
          dest: 'dist/main.min.js'
        }
      },
      sass: {
        dev: {
          files: {
            'dist/styles.css':'source/scss/main.scss'
          }
        }
      },
      htmlmin: {
        dev: {
          options: {
            removeComments: true,
            collapseWhitespace: true
          },
          files:  [
            {
              expand: true,
              cwd: 'source/',
              src: ['**/*.html'],
              dest: 'dist/',
            },
          ],
        }
      },
      watch: {
        css: {
          files: 'source/scss/**/*.scss',
          tasks: ['sass']
        },
        js: {
          files: 'source/js/**/*.js',
          tasks: ['uglify']
        },
        html: {
          files: 'source/**/*.html',
          tasks: ['htmlmin']
        },
        php: {
          files: 'source/**/*.php',
          tasks: ['copy:php']
        },
        assets: {
          files: 'source/images**/*',
          tasks: ['copy:assets']
        }
      },
      clean: ['dist'],
      copy: {
        php: {
          expand: true,
          cwd: 'source',
          src: '**/*.php',
          dest: 'dist/',
        },
        assets: {expand: true, cwd: 'source/', src: ['images/**'], dest: 'dist/'},
      },
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Default task(s).
    grunt.registerTask('default', ['watch']);

    grunt.registerTask('build', ['clean','uglify','sass','htmlmin','copy']);

  };
