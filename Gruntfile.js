
module.exports = function(grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // sass
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                },
                files: {
                    'assets/main-styles.css': 'assets/main-styles.scss',
                }
            },
        },

        // autoprefixer
        autoprefixer: {
            // prefix main file
            single_file: {
              options: {
                browsers: ['last 2 versions', 'ie 8', 'ie 9', 'ios 6', 'android 4'],
                map: true
              },
              src: 'assets/main-styles.css',
              dest: 'assets/main-styles.css'
            },
        },

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['assets/css/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer']
            },
            js: {
                files: 'js/components/init.js',
                tasks: ['jshint', 'uglify']
            }
        },

    });

    
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // register task
    grunt.registerTask('default', ['sass', 'autoprefixer', 'watch']);

};