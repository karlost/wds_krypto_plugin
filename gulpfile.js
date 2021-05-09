// GULP PACKAGES

var gulp  = require('gulp'),
    browserSync = require('browser-sync').create();

var url = 'http://localhost/testsite/';

//default task
gulp.task('default', function ( ) {

    return new Promise(function(resolve, reject) {

        console.log("HTTP Server Started");
        resolve();

    });

});

gulp.task('dev', function() {

    browserSync.init({

		files: [{

			match: [

				//php files
				//'./**//**.php', 
				//style.css
				//"style.css",
				// css files 
				//"assets/css/**//**.css",
				//javascript files
				//"assets/js/**//**.js"

			],
			fn:  function (event, file) {
				this.reload()
			}

		  } ],
		  proxy: url, 
		  port: 3000,
		  injectChanges: true 
	  });

});