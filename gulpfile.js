/**
 *
 * Gulpfile setup
 *
 * @since 1.0.0
 * @author Ibon Azkoitia
 * @package wpbilbao
 * @forks Ahmad Awais - Advanced Gulp Workflow for WordPress Themes
 */


// Project configuration
var project = 'wpbilbao', // Project name, used for build zip.
    url = 'www.wpbilbao.es', // Local Development URL for BrowserSync. Change as-needed.
    build = './buildtheme/', // Files that you want to package into a zip go here
    buildInclude = [
        // include common file types
        '**/*.php',
        '**/*.html',
        '**/*.css',
        '**/*.js',
        '**/*.svg',
        '**/*.ttf',
        '**/*.otf',
        '**/*.eot',
        '**/*.woff',
        '**/*.woff2',

        // include specific files and folders
        'screenshot.png',
        'images/favicon.ico',

        // exclude files and folders
        '!node_modules/**/*',
        '!.gitignore',
        '!.git/**/*'
    ];

// Load plugins
var gulp = require('gulp'),
    browserSync = require('browser-sync'), // Asynchronous browser loading on .scss file changes
    reload = browserSync.reload,
    autoprefixer = require('gulp-autoprefixer'), // Autoprefixing magic
    minifycss = require('gulp-uglifycss'),
    filter = require('gulp-filter'),
    uglify = require('gulp-uglify'),
    imagemin = require('gulp-imagemin'),
    newer = require('gulp-newer'),
    rename = require('gulp-rename'),
    concat = require('gulp-concat'),
    notify = require('gulp-notify'),
    cmq = require('gulp-combine-media-queries'),
    runSequence = require('gulp-run-sequence'),
    sass = require('gulp-sass'),
    plugins = require('gulp-load-plugins')({camelize: true}),
    ignore = require('gulp-ignore'), // Helps with ignoring files and directories in our run tasks
    rimraf = require('gulp-rimraf'), // Helps with removing files and directories in our run tasks
    zip = require('gulp-zip'), // Using to zip up our packaged theme into a tasty zip file that can be installed in WordPress!
    plumber = require('gulp-plumber'), // Helps prevent stream crashing on errors
    cache = require('gulp-cache'),
    sourcemaps = require('gulp-sourcemaps');
scsslint = require('gulp-scss-lint');


/**
 * Browser Sync
 *
 * Asynchronous browser syncing of assets across multiple devices!! Watches for changes to js, image and php files
 * Although, I think this is redundant, since we have a watch task that does this already.
 */
gulp.task('browser-sync', function () {
    var files = [
        '**/*.php',
        '**/*.{png,jpg,gif}'
    ];
    browserSync.init(files, {

        // Read here http://www.browsersync.io/docs/options/
        proxy: url,

        port: 8080,

        // Tunnel the Browsersync server through a random Public URL
        tunnel: true,

        // Attempt to use the URL "http://my-private-site.localtunnel.me"
        tunnel: "wpbilbao",

        // Inject CSS changes
        injectChanges: true

    });
});


/**
 * Styles
 *
 * Looking at src/sass and compiling the files into Expanded format, Autoprefixing and sending the files to the build folder
 *
 * Sass output styles: https://web-design-weekly.com/2014/06/15/different-sass-output-styles/
 */
gulp.task('styles', function () {
    return gulp.src('sass/*.scss')
        .pipe(plumber())
        // .pipe(sourcemaps.init())
        .pipe(sass({
            errLogToConsole: true,

            outputStyle: 'compressed',
            // outputStyle: 'compact',
            // outputStyle: 'nested',
            // outputStyle: 'expanded',
            precision: 10
        }))
        // .pipe(sourcemaps.write({includeContent: false}))
        // .pipe(sourcemaps.init({loadMaps: true}))
        // .pipe(autoprefixer('last 2 version', '> 1%', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        // .pipe(sourcemaps.write('.'))
        .pipe(plumber.stop())
        .pipe(gulp.dest('./'))
        .pipe(filter('**/*.css')) // Filtering stream to only css files
        //.pipe(cmq()) // Combines Media Queries
        .pipe(reload({stream: true})) // Inject Styles when style file is created
        .pipe(minifycss({
            maxLineLen: 80
        }))
        .pipe(gulp.dest('./'))
        .pipe(reload({stream: true})) // Inject Styles when min style file is created
        .pipe(notify({message: 'Styles task complete', onLast: true}))
});


/**
 * Scripts: Vendors
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */
gulp.task('vendorsJs', function () {
    return gulp.src(['js/vendor/bootstrap.min.js'])
        .pipe(concat('vendors.min.js'))
        .pipe(gulp.dest('js/'))
        .pipe(uglify())
        .pipe(gulp.dest('js/'))
        .pipe(notify({message: 'Vendor scripts task complete', onLast: true}));
});

/**
 * Scripts: Custom
 *
 * Look at src/js and concatenate those files, send them to assets/js where we then minimize the concatenated file.
 */

gulp.task('scriptsJs', function () {
    return gulp.src('js/custom/wpbilbao.js')
        .pipe(concat('wpbilbao.min.js'))
        .pipe(gulp.dest('js/'))
        .pipe(uglify())
        .pipe(gulp.dest('js/'))
        .pipe(notify({message: 'Custom scripts task complete', onLast: true}));
});


/**
 * Images
 *
 * Look at src/images, optimize the images and send them to the appropriate place
 */
gulp.task('images', function () {

// Add the newer pipe to pass through newer images only
    return gulp.src(['images/raw/**/*.{png,jpg,gif}'])
        .pipe(newer('imgages/'))
        .pipe(rimraf({force: true}))
        .pipe(imagemin({optimizationLevel: 7, progressive: true, interlaced: true}))
        .pipe(gulp.dest('images/'))
        .pipe(notify({message: 'Images task complete', onLast: true}));
});


/**
 * Clean gulp cache
 */
gulp.task('clear', function () {
    cache.clearAll();
});


/**
 * Clean tasks for zip
 *
 * Being a little overzealous, but we're cleaning out the build folder, codekit-cache directory and annoying DS_Store files and Also
 * clearing out unoptimized image files in zip as those will have been moved and optimized
 */

gulp.task('cleanup', function () {
    return gulp.src(['**/.sass-cache', '**/.DS_Store'], {read: false}) // much faster
        .pipe(ignore('node_modules/**')) //Example of a directory to ignore
        .pipe(rimraf({force: true}))
    // .pipe(notify({ message: 'Clean task complete', onLast: true }));
});
gulp.task('cleanupFinal', function () {
    return gulp.src(['**/.sass-cache', '**/.DS_Store'], {read: false}) // much faster
        .pipe(ignore('node_modules/**')) //Example of a directory to ignore
        .pipe(rimraf({force: true}))
    // .pipe(notify({ message: 'Clean task complete', onLast: true }));
});

/**
 * Build task that moves essential theme files for production-ready sites
 *
 * buildFiles copies all the files in buildInclude to build folder - check variable values at the top
 * buildImages copies all the images from img folder in assets while ignoring images inside raw folder if any
 */

gulp.task('buildFiles', function () {
    return gulp.src(buildInclude)
        .pipe(gulp.dest(build))
        .pipe(notify({message: 'Copy from buildFiles complete', onLast: true}));
});


/**
 * Images
 *
 * Look at src/images, optimize the images and send them to the appropriate place
 */
gulp.task('buildImages', function () {
    return gulp.src(['images/**/*', '!images/raw/**'])
        .pipe(gulp.dest(build + 'images/'))
        .pipe(plugins.notify({message: 'Images copied to buildTheme folder', onLast: true}));
});

/**
 * Zipping build directory for distribution
 *
 * Taking the build folder, which has been cleaned, containing optimized files and zipping it up to send out as an installable theme
 */
gulp.task('buildZip', function () {
    // return   gulp.src([build+'/**/', './.jshintrc','./.bowerrc','./.gitignore' ])
    return gulp.src(build + '/**/')
        .pipe(zip(project + '.zip'))
        .pipe(gulp.dest('./'))
        .pipe(notify({message: 'Zip task complete', onLast: true}));
});


// ==== TASKS ==== //
/**
 * Gulp Default Task
 *
 * Compiles styles, fires-up browser sync, watches js and php files. Note browser sync task watches php files
 *
 */

    // Package Distributable Theme
gulp.task('build', function (cb) {
    runSequence('styles', 'cleanup', 'vendorsJs', 'scriptsJs', 'buildFiles', 'buildImages', 'buildZip', 'cleanupFinal', cb);
});


// Watch Task
gulp.task('default', ['styles', 'vendorsJs', 'scriptsJs', 'images', 'browser-sync'], function () {
    gulp.watch('images/**/*', ['images']);
    gulp.watch('sass/**/*.scss', ['styles', browserSync.reload]);
    gulp.watch('js/**/*.js', ['scriptsJs', browserSync.reload]);

});


// SCSS Lint
gulp.task('scsslint', function () {
    return gulp.src([
            'sass/supporting/base/_links.scss',
            'sass/supporting/base/_variables.scss',
            'sass/supporting/layouts/*.scss',
            '!' + 'sass/*.scss'
        ])
        .pipe(scsslint());
});
