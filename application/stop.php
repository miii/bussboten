<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
<meta property="og:title" content="Bussboten - När kommer bussen förbi <?php echo $stopName; ?>?"/>
<meta property="og:description" content="Bussboten visar liveinformation om busstider och bussarnas position i Gävle. Perfekt för dig som inte vill vänta ute i kylan på en buss som aldrig tycks komma."/>
<meta property="og:url" content="<?php echo base_url() ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="<?php echo base_url('images/ogimage.png'); ?>"/>
<title>Bussboten - När kommer bussen?</title>
<link href="<?php echo base_url('css/reset.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/style.css?v=030314'); ?>" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url('images/favicon.png'); ?>" type="image/png">
<link rel="apple-touch-icon" href="<?php echo base_url('images/homescreen.png'); ?>" />
</head>

<body id="body">

<section id="container">
	<h1><span id="stopname"><?php echo $stopName; ?></span></h1>
	
	<div class="da desktopad2">
		<script type="text/javascript">
		    <!--
		    document.write(
		        '<scr'+
		        'ipt type="text/javascript" src="http://track.double.net/display.js?adspace=15081&target=_blank&t=' + new Date().getTime() + '"></scr'+
		        'ipt>'
		    );
		    -->
		</script>
	</div>
	
	<div id="stoplist">
		<h5>Välj busshållplats: <a target="_blank" href="<?php echo base_url('faq'); ?>" class="faqlink">FAQ</a></h5>
		<select>
			<option value="<?php echo base_url(); ?>">Hitta närmsta</option>

			<?php
			
			foreach($stops as $stop) {
				$selected = $stopURL == $stop['url'] ? 'selected' : '';
				echo "<option {$selected} value=\"" . base_url('h/' . $stop['url']) . "\">{$stop['name']}</option>";
			}
			
			?>
		</select>
	</div>
	
	<section id="cards"></section>
	
	<div class="mobilead">
		<script type="text/javascript">
		    <!--
		    document.write(
		        '<scr'+
		        'ipt type="text/javascript" src="http://track.double.net/display.js?adspace=15082&target=_blank&t=' + new Date().getTime() + '"></scr'+
		        'ipt>'
		    );
		    -->
		</script>
	</div>
	<h6>&copy; <a target="_blank" href="http://jacob-andersson.com/">Jacob Andersson</a></h6>
</section>

<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6U642X5-gY3t4bB3y2tkdW7bKstf53o&sensor=false"></script>
<script>
base_url = '<?php echo base_url(); ?>';
stopID = <?php echo $stopID; ?>;
stopLatitude = <?php echo $lat; ?>;
stopLongitude = <?php echo $long; ?>;
</script>
<script src="<?php echo base_url('js/stop.js?v=040314'); ?>"></script>
<script src="<?php echo base_url('js/bussboten.js?v=040314'); ?>"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48277100-1', 'bussboten.se');
  ga('send', 'pageview');
</script>

</body>
</html>