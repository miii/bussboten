<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
<meta property="og:title" content="Bussboten - När kommer bussen?"/>
<meta property="og:description" content="Bussboten visar liveinformation om busstider och bussarnas position i Gävle. Perfekt för dig som inte vill vänta ute i kylan på en buss som aldrig tycks komma."/>
<meta property="og:url" content="<?php echo base_url() ?>"/>
<meta property="og:type" content="website"/>
<meta property="og:image" content="<?php echo base_url('images/ogimage.png'); ?>"/>
<meta property="description" content="Bussboten visar liveinformation om busstider och bussarnas position i Gävle. Perfekt för dig som inte vill vänta ute i kylan på en buss som aldrig tycks komma."/>
<title>Bussboten - FAQ</title>
<link href="<?php echo base_url('css/reset.css'); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url('css/style.css?v=030314'); ?>" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo base_url('images/favicon.png'); ?>" type="image/png">
<link rel="apple-touch-icon" href="<?php echo base_url('images/homescreen.png'); ?>" />
</head>

<body id="body">

<section id="container">
	<h1>FAQ</h1>
	
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
	
	<section id="cards" class="faq">
		<div class="card">
			<h5><span>Vad är bussboten?</span></h5>
			<p>
				Bussboten visar liveinformation om busstider och bussarnas position i Gävle.
				Perfekt för dig som inte vill vänta ute i kylan på en buss som aldrig tycks komma.
			</p>
			
			<h5><span>Hur funkar det?</span></h5>
			<p>
				Det sitter GPS-puckar på stadsbussarna i Gävle som då och då skickar sina koordinater.
				Denna information har jag sedan använt för att pilla ihop den här hemsidan.
			</p>
		
			<h5><span>Finns det någon app?</span></h5>
			<p>
				Ja, det finns idag en app till Android. Den går att ladda hem <a target="_blank" href="http://bussboten.se/bussboten.apk">här</a>.
			</p>
			
			<h5><span>Varför inte till iOS?</span></h5>
			<p>
				Eftersom det kräver att jag sitter på Mac, men vill någon pröjsa så är det lugnt för mig.
			</p>
			
			<h5><span>Kan jag lita på att tiderna stämmer?</span></h5>
			<p>
				Ja, det skulle jag säga. Alla tider beräknas av RealTime Light medan jag själv har byggt algoritmen för att hitta nästa buss.
				Gå ut till busshållplatsen någon minut tidigare om du känner dig osäker.
			</p>
			
			<h5><span>Varför finns inte fler busslinjer med?</span></h5>
			<p>
				GPS-puckarna sitter bara på stadsbussarna.
				Är det någon linje som du saknar rekommenderar jag dig att kontakta stadsbussarna.
			</p>
			
			<h5><span>Den visar fel buss på kartan</span></h5>
			<p>
				Algoritmen för att leta upp nästa buss är fortfarande i beta och kan balla ur ibland, framför allt vid vägarbeten.
				Jag försöker hela tiden förbättra den. Den beräknade ankomsten ska dock alltid stämma.
			</p>
			
			<h5><span>Det kom nyss en buss även fast din hemsida sa annat, avgå!</span></h5>
			<p>
				Det <strong>kan</strong> i vissa fall (väldigt sällan vad jag märkt) dyka upp bussar innan avgångar som står på hemsidan.
				Det verkar som ett fåtal bussar saknar puckar. Inget jag kan göra något åt tyvärr.<br />
				<br />
				I vilket fall så ska alla avgångar på hemsidan vara garanterade!
			</p>
			
			<h5><span>Vem har gjort hemsidan?</span></h5>
			<p>
				Jag är grabb på 19 vårar som gjort den här sidan som ett gymnasieprojekt. Jag älskar musik och att pilla ihop hemsidor som denna.
				Är det något annat du undrar? Fråga mig!
			</p>
			
			<h5><span>Hur får du reda på informationen?</span></h5>
			<p>
				Alla information om busshållplatser och hållplatstider hämtar jag från tjänsten Realtime Light (<a target="_blank" href="http://realtimelight.se/gavle">http://realtimelight.se/gavle</a>).
				Jag kan således inte påverka vilka busslinjer som ska visas.
			</p>
			
			<h5><span>Kan man kontakta dig på något sätt?</span></h5>
			<p>
				Visst kan du det. Dra iväg ett mail till <a href="mailto:jacob@bussboten.se" target="_blank">jacob@bussboten.se</a> så svarar jag så fort jag kan.
				Finns även på <a target="_blank" href="http://twitter.com/jacobandersson">Twitter</a> för de som använder det. Hör gärna av er och säg vad ni tycker om sidan.
			</p>
		</div>
		<div class="card changelog">
			<h5><span>Changelog</span></h5>
			<code><pre>
200314
  Tidigare valda hållplatser sparas nu under favoriter.

180314
  Release.
			</pre></code>
		</div>
	</section>
	
	<div class="mobilead">
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<!-- Mobilbanner -->
		<ins class="adsbygoogle"
		     style="display:inline-block;width:320px;height:50px"
		     data-ad-client="ca-pub-2910578344302555"
		     data-ad-slot="4798796826"></ins>
		<script>
		(adsbygoogle = window.adsbygoogle || []).push({});
		</script>
		<!--<script type="text/javascript">
		    <!--
		    document.write(
		        '<scr'+
		        'ipt type="text/javascript" src="http://track.double.net/display.js?adspace=15082&target=_blank&t=' + new Date().getTime() + '"></scr'+
		        'ipt>'
		    );
		    --
		</script>-->
	</div>
	<h6>&copy; <a target="_blank" href="http://jacob-andersson.com/">Jacob Andersson</a></h6>
</section>

<script src="<?php echo base_url('js/jquery.min.js'); ?>"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw6U642X5-gY3t4bB3y2tkdW7bKstf53o&sensor=false"></script>
<?php echo $this->load->view('other/website_analytics'); ?>

</body>
</html>