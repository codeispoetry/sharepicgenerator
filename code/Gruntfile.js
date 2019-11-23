module.exports = function (grunt) {

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            build: {
                src: 'build/js/*.js',
                dest: 'dist/assets/js/main.min.js'
            }
        },
        sass: {
            dev: {
                files: {
                    'dist/assets/css/styles.css': 'build/scss/main.scss'
                }
            }
        },
        watch: {
            css: {
                files: 'build/scss/**/*.scss',
                tasks: ['sass','postcss']
            },
            js: {
                files: 'build/js/**/*.js',
                tasks: ['uglify']
            },
        },
        postcss: {
            options: {
                map: {
                    inline: false, // save all sourcemaps as separate files...
                    annotation: 'dist/assets/css/' // ...to the specified directory
                },

                processors: [
                    require('pixrem')(), // add fallbacks for rem units
                    require('autoprefixer')(), // add vendor prefixes
                    require('cssnano')() // minify the result
                ]
            },
            dist: {
                src: 'dist/assets/css/*.css'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify-es');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-postcss');


    // Default task(s).
    grunt.registerTask('default', ['watch']);

    grunt.registerTask('build', ['uglify', 'sass','postcss']);

};
