
module.exports = function(grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // sass
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    sourcemap: 'none',
                },
                files: {
                    'assets/css/sc-catalog.css': 'assets/css/sc-catalog.scss',
                }
            },
        },

        // autoprefixer
        autoprefixer: {
            // prefix main file
            single_file: {
              options: {
                browsers: ['last 2 versions', 'ie 8', 'ie 9', 'ios 6', 'android 4'],
                map: false
              },
              src: 'assets/css/sc-catalog.css',
              dest: 'assets/css/sc-catalog.css'
            },
        },

        // watch for changes and trigger sass, jshint, uglify and livereload
        watch: {
            sass: {
                files: ['assets/css/*.{scss,sass}'],
                tasks: ['sass', 'autoprefixer']
            },
        },

    });

    
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-autoprefixer');
    grunt.loadNpmTasks('grunt-contrib-watch');

    // register task
    grunt.registerTask('default', ['sass', 'autoprefixer', 'watch']);

};