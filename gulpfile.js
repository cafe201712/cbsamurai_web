var gulp = require('gulp');

/*
 * bower でダウンロードしたライブラリを bower_components ディレクトリから
 * 実行環境である webroot/assets ディレクトリ以下に配置する
 */

// CSS の配置
gulp.task('css', function() {
    gulp.src([
        'bower_components/bootstrap/dist/css/*.css',
        'bower_components/bootstrap/dist/css/*.map',
        'bower_components/select2/dist/css/*.css',
        'bower_components/select2-bootstrap-theme/dist/*.css'
    ]).pipe(gulp.dest('webroot/assets/css'));
});

// JavaScript の配置
gulp.task('js', function() {
    gulp.src([
        'bower_components/jquery/dist/*.js',
        'bower_components/jquery/dist/*.map',
        'bower_components/bootstrap/dist/js/*.js',
        'bower_components/clipboard/dist/*.js',
        'bower_components/select2/dist/js/*',
    ]).pipe(gulp.dest('webroot/assets/js'));
});

// font の配置
gulp.task('font', function() {
    gulp.src([
        'bower_components/bootstrap/dist/fonts/*',
    ]).pipe(gulp.dest('webroot/assets/fonts'));
});

gulp.task('default', ['css', 'js', 'font']);