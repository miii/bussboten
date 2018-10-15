<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
<link href="<?php echo base_url('css/reset.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/style.css?v=200314'); ?>" rel="stylesheet" type="text/css" />
</head>

<body id="body">

<section id="container">
	<h1><span id="stopname">Söker...</span></h1>
	
	<div id="stoplist">
		<h5>Välj busshållplats:</h5>
		<select>
			<optgroup id="favorites" label="Favoriter">
				<option value="<?php echo base_url('android/auto'); ?>">Hitta närmaste</option>
			</optgroup>
			<optgroup label="Alla busshållplatser">
				<?php
				
				foreach($stops as $stop) {
					echo "<option value=\"" . base_url('android/stop/' . $stop['url']) . "\">{$stop['name']}</option>";
				}
				
				?>
			</optgroup>
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

<a href="<?php echo base_url('bussboten.apk'); ?>">
	<div id="update">Ny version tillgänglig</div>
</a>

<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6U642X5-gY3t4bB3y2tkdW7bKstf53o&sensor=false"></script>
<script>
base_url = '<?php echo base_url(); ?>';
version = '1.1.0';

$(document).ready(function() {
	if ('<?php echo $version; ?>' !== '' && version !== '<?php echo $version; ?>')
		$('#update').show();
});
</script>
<script src="<?php echo base_url('js/all.js?v=040314'); ?>"></script>
<script src="<?php echo base_url('js/bussboten.js?v=200314'); ?>"></script>
<?php echo $this->load->view('other/website_analytics'); ?>

</body>
</html>