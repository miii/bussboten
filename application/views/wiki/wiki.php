<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Wiki</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" />
<link href="css/wiki.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="http://highlightjs.org/static/styles/railscasts.css">
</head>

<body>

<section id="methods">
	<h1>Wiki</h1>
	<ul>
		<li><a id="top" href="#background">Bakgrund</a></li>
		<li><a href="#stops"><span>/api/</span>stops</a></li>
		<li><a href="#stopsnearby"><span>/api/</span>stopsnearby</a></li>
		<li><a href="#departures"><span>/api/</span>departures</a></li>
		<li><a href="#nextbus"><span>/api/</span>nextbus</a></li>
	</ul>
</section>

<section id="container">
	<?php echo $content; ?>
</section>

<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script>
function animateScroll(parent, speed) {
	var target = parent.hash.replace("#", "");

    $('html, body').stop().animate({
        'scrollTop': $('a[name=' + target + ']').offset().top - 30
    }, speed, function () {
        window.location.hash = '#' + target;
    });
}

$(document).ready(function(){
	$('a[href^="#"]').on('click', function (e) {
	    e.preventDefault();

	    animateScroll(this, 600);
	});
	
	$('html').doubletap(function() {
		$('html, body').stop().animate({
	        'scrollTop': 0
	  	}, 600);
	});
	
	animateScroll(location, 1000);
});
</script>
<script src="http://yandex.st/highlightjs/8.0/highlight.min.js"></script>
<script src="js/jquery.doubletap.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

</body>

</html>