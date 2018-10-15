<section class="card">
	<a name="background"></a>
	<h2>Bakgrund</h2>
	
	<h3>Hur ser svaren ut?</h3>
	<p>
		Varje svar från servern består av en svarkod och det data som har efterfrågats.<br />
		Vad de olika svarkoderna betyder kan du se längre ner i dokumentationen.
	</p>
<pre><code>{
	"status_code": 5,
	"data": []
}</code></pre>
	
	<h3>Svarskoder och förklaringar</h3>
	<table>
		<thead>
			<tr>
				<td>Svarskod</td>
				<td>Beskrivning</td>
				<td>Förklaring</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="code">0</td>
				<td>Ogiltig förfrågan</td>
				<td></td>
			</tr>
			<tr>
				<td class="code">1</td>
				<td>Sessionkakan från servern har gåt ut</td>
				<td>Sessionkakan som används för att hämta datan från RTL-servern har gått ut. Ny kaka hämtas i samband med förfrågan. Nästa förfrågan mot API:t kommer att returnera ett resultat.</td>
			</tr>
			<tr>
				<td class="code">2</td>
				<td>Begäran gjorde timeout</td>
				<td>RTL-servern gick inte att nås inom den bestämda tidsramen.</td>
			</tr>
			<tr>
				<td class="code">3</td>
				<td>Ogiltiga koordinater</td>
				<td></td>
			</tr>
			<tr>
				<td class="code">4</td>
				<td>Ogiltiga busslinje</td>
				<td></td>
			</tr>
			<tr>
				<td class="code">5</td>
				<td>Förfrågan lyckades</td>
				<td></td>
			</tr>
		</tbody>
	</table>
</section>

<section class="card">
	<a name="stops"></a>
	<h2>/api/stops</h2>
	<h3>Beskrivning</h3>
	<p>
		Listar alla busshållplatser som finns registrerade.
	</p>
	<h3>Exempel</h3>
	<p>Förfrågan:</p>
	<pre><code>/api/stops</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		{
			"name": "Almvägen",
			"stopID": 2707,
			"url": "almvagen"
		},
		
		[Fler resultat]
	}
}</code></pre>
	<h3>Data</h3>
	<table>
		<thead>
			<tr>
				<td>Namn</td>
				<td>Beskrivning</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="code">name</td>
				<td>Busshållplatsens namn</td>
			</tr>
			<tr>
				<td class="code">stopID</td>
				<td>Busshållplatsens ID</td>
			</tr>
			<tr>
				<td class="code">url</td>
				<td>Busshållplatsens URL</td>
			</tr>
		</tbody>
	</table>
</section>

<section class="card">
	<a name="stopsnearby"></a>
	<h2>/api/stopsnearby</h2>
	<h3>Beskrivning</h3>
	<p>
		Med hjälp av <span>stopsnearby</span> kan du hitta närmsta busshållplatsen baserat på latitud och longitud.
		<table>
			<thead>
				<tr>
					<td>Namn</td>
					<td>Beskrivning</td>
					<td>Exempelvärde</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="code">latitude</td>
					<td>Användarens latitud</td>
					<td>60.6648371</td>
				</tr>
				<tr>
					<td class="code">longitude</td>
					<td>Användarens longitud</td>
					<td>17.2089179</td>
				</tr>
				<tr>
					<td colspan="3" class="thead">Frivilliga variabler</td>
				</tr>
				<tr>
					<td class="code">line</td>
					<td>Busslinje</td>
					<td>2</td>
				</tr>
			</tbody>
		</table>
	</p>
	<h3>Exempel</h3>
	<p>Förfrågan:</p>
	<pre><code>/api/stopsnearby?latitude=60.6641258&longitude=17.206999</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		"distance": {
			"distance": 0.0026301999999987,
			"meters": 131
		},
		"stop": {
			"stopID": 2921,
			"name": "Vikingavägen",
			"latitude": 60.6648371,
			"longitude": 17.2089179
		}
	}
}</code></pre>
	<p>
		Om du vill begränsa detta till en viss busslinje lägger du till variabeln <span>line</span>.
	</p>
	<p>Förfrågan:</p>
	<pre><code>/api/stopsnearby?latitude=60.6641258&longitude=17.206999&line=2</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		"distance": {
			"distance": 0.060662799999996,
			"meters": 3106
		},
		"stop": {
			"stopID": 2838,
			"name": "Polhemsskolan",
			"latitude": 60.6684328,
			"longitude": 17.1506432
		}
	}
}</code></pre>
	<h3>Data</h3>
	<table>
		<thead>
			<tr>
				<td>Namn</td>
				<td>Beskrivning</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="code"><span>distance</span>distance</td>
				<td>Matematisk sträcka till busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>distance</span>meters</td>
				<td>Sträcka till busshållplatsen i meter</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>stopID</td>
				<td>Busshållplatsens ID</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>name</td>
				<td>Namn på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>latitude</td>
				<td>Latitud på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>longitude</td>
				<td>Longitud på busshållplatsen</td>
			</tr>
		</tbody>
	</table>
</section>

<section class="card">
	<a name="departures"></a>
	<h2>/api/departures</h2>
	<h3>Beskrivning</h3>
	<p>
		Med hjälp av <span>departures</span> kan du ta reda på väntade avgångar från en specifik busshållplats.
		<table>
			<thead>
				<tr>
					<td>Namn</td>
					<td>Beskrivning</td>
					<td>Exempelvärde</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="code">stopID</td>
					<td>Busshållplatsens ID</td>
					<td>2921</td>
				</tr>
				<tr>
					<td colspan="3" class="thead">Frivilliga variabler</td>
				</tr>
				<tr>
					<td class="code">lineID</td>
					<td>Busslinjens ID</td>
					<td>64</td>
				</tr>
			</tbody>
		</table>
	</p>
	<h3>Exempel</h3>
	<p>Förfrågan:</p>
	<pre><code>/api/departures?stopID=2921</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		"stop": {
			"stopID": 2921,
			"name": "Vikingavägen",
			"latitude": 60.6648371,
			"longtude": 17.2089179
		},
		"buses": [
			{
				"lineID": 58,
				"name": "3 mot Stigslund-Hille",
				"line": 3,
				"departureIn": 95
			},
			{
				"lineID": 64,
				"name": "12 mot Sätra",
				"line": 12,
				"departureIn": 275
			},
			{
				"lineID": 57,
				"name": "3 mot Södra Bomhus",
				"line": 3,
				"departureIn": 575
			},
			{
				"lineID": 63,
				"name": "12 mot Södra Bomhus-Bomhus",
				"line": 12,
				"departureIn": 1305
			}
		]
	}
}</code></pre>
	<p>
		Om du söker avgångar på en speciell linje, ange <span>lineID</span>.
	</p>
	<p>Förfrågan:</p>
	<pre><code>/api/departures?stopID=2921&lineID=64</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		"stop": {
			"stopID": 2921,
			"name": "Vikingavägen",
			"latitude": 60.6648371,
			"longtude": 17.2089179
		},
		"buses": [
			{
				"lineID": 64,
				"name": "12 mot Sätra",
				"line": 12,
				"departureIn": 226
			}
		]
	}
}</code></pre>
	<h3>Data</h3>
	<table>
		<thead>
			<tr>
				<td>Namn</td>
				<td>Beskrivning</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="code"><span>stop</span>stopID</td>
				<td>Busshållplatsens ID</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>name</td>
				<td>Namn på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>latitude</td>
				<td>Latitud på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>stop</span>longitude</td>
				<td>Longitud på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>buses</span>lineID</td>
				<td>Busslinjens ID</td>
			</tr>
			<tr>
				<td class="code"><span>buses</span>name</td>
				<td>Busslinjens namn</td>
			</tr>
			<tr>
				<td class="code"><span>buses</span>line</td>
				<td>Busslinje</td>
			</tr>
			<tr>
				<td class="code"><span>buses</span>departureIn</td>
				<td>Beräknat antal sekunder till avgång</td>
			</tr>
		</tbody>
	</table>
</section>

<section class="card">
	<a name="nextbus"></a>
	<h2>/api/nextbus</h2>
	<h3>Beskrivning</h3>
	<p>
		Med hjälp av <span>nextbus</span> kan du hitta nästa buss baserat på busshållplats.
		<table>
			<thead>
				<tr>
					<td>Namn</td>
					<td>Beskrivning</td>
					<td>Exempelvärde</td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="code">stopID</td>
					<td>Busshållplatsens ID</td>
					<td>2921</td>
				</tr>
				<tr>
					<td class="code">lineID</td>
					<td>Busslinjer (separerade med ",")</td>
					<td>57,58</td>
				</tr>
			</tbody>
		</table>
	</p>
	<h3>Exempel</h3>
	<p>Förfrågan:</p>
	<pre><code>/api/nextbus?stopID=2921&lineID=57,58</code></pre>
	<p>Svar:</p>
	<pre><code>{
	"status_code": 5,
	"data": {
		"stopID": 2921,
		"name": "Vikingavägen",
		"lines": {
			"57": {
				"longitude": 17.1484917,
				"latitude": 60.69231,
				"name": "226",
				"departureIn": 17,
				"estimatedDeparture": 1393168284000
			},
			"58": {
				"departureIn": 15,
				"estimatedDeparture": 1393168184000
			}
		}
	}
}</code></pre>
	<h3>Data</h3>
	<table>
		<thead>
			<tr>
				<td>Namn</td>
				<td>Beskrivning</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="code">stopID</td>
				<td>Busshållplatsens ID</td>
			</tr>
			<tr>
				<td class="code">name</td>
				<td>Namn på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>lines</span><span>&lt;id&gt;</span>latitude</td>
				<td>Latitud på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>lines</span><span>&lt;id&gt;</span>longitude</td>
				<td>Longitud på busshållplatsen</td>
			</tr>
			<tr>
				<td class="code"><span>lines</span><span>&lt;id&gt;</span>name</td>
				<td>Den enskilda bussens namn</td>
			</tr>
			<tr>
				<td class="code"><span>lines</span><span>&lt;id&gt;</span>departureIn</td>
				<td>Beräknat antal sekunder till avgång</td>
			</tr>
			<tr>
				<td class="code"><span>lines</span><span>&lt;id&gt;</span>estimatedDeparture</td>
				<td>Beräknad avgång i UNIX-tid</td>
			</tr>
		</tbody>
	</table>
</section>