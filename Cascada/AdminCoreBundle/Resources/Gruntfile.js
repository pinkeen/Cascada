module.exports = function(grunt) {

    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        dir: {
            bower: 'vendor',
            styles: 'scss',
            scripts: 'js',
            dest: 'public'
        },
        concat: {
            pinkeencascada: {
                files: {
                    '<%= dir.dest %>/js/top.js': [
                        '<%= dir.bower %>/jquery/dist/jquery.js',
                        '<%= dir.bower %>/modernizr/modernizr.js',
                        '<%= dir.bower %>/respond/src/respond.js'
                    ],
                    '<%= dir.dest %>/js/all.js': [
                        '<%= dir.scripts %>/**/*.js',
                        '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/modal.js',
                        '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/alert.js',
                        '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tooltip.js',
                        '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/tab.js',
                        '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/javascripts/bootstrap/popover.js',
                        '<%= dir.bower %>/bootbox/bootbox.js'
                    ]
                }
            }
        },
        uglify: {
            options: {
                sourceMap: true
            },
            pinkeencascada: {
                files: {
                    '<%= dir.dest %>/js/top.min.js': [
                        '<%= dir.dest %>/js/top.js'
                    ],
                    '<%= dir.dest %>/js/all.min.js': [
                        '<%= dir.dest %>/js/all.js'
                    ]
                }
            }
        },
        sass: {
            options: {
                sourcemap: true,
                style: 'compressed',
                loadPath: '<%= dir.bower %>'
            },
            pinkeencascada: {
                files: {
                    '<%= dir.dest %>/css/styles.css': '<%= dir.styles %>/styles.scss'
                }
            }
        },
        copy: {
            pinkeencascada: {
                files: [
                    {
                        expand: true,
                        cwd: '<%= dir.bower %>/open-sans/fonts',
                        src: '**/*',
                        dest: '<%= dir.dest %>/fonts/open-sans/'
                    },
                    {
                        expand: true,
                        cwd: '<%= dir.bower %>/bootstrap-sass-official/vendor/assets/fonts/bootstrap',
                        src: '**/*',
                        dest: '<%= dir.dest %>/fonts/bootstrap/'
                    },
                    {
                        expand: true,
                        cwd: '<%= dir.bower %>/fontawesome/fonts',
                        src: '**/*',
                        dest: '<%= dir.dest %>/fonts/fontawesome/'
                    }
                ]
            }
        },
        watch: {
            scripts: {
                files: ['<%= dir.scripts %>/**/*.js'],
                tasks: ['scripts'],
                options: {
                    spawn: true,
                    interrupt: true,
                    atBegin: true
                }
            },
            styles: {
                files: ['<%= dir.styles %>/**/*.scss'],
                tasks: ['styles'],
                options: {
                    spawn: true,
                    interrupt: true,
                    atBegin: true,
                    livereload: true
                }
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-contrib-copy');

    grunt.registerTask('default', ['concat', 'uglify', 'sass', 'copy']);
    grunt.registerTask('styles', ['sass']);
    grunt.registerTask('scripts', ['concat', 'uglify']);
};