<?php

class API_Model extends CI_Model implements iAPI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function GetRoutepoints()
	{
		$routepoints = $this->cache->file->get('routepoints_cache');
		
		if (!$routepoints) {
			$routepointsRaw = $this->request_model->HttpRequest('http://wp.faltcom.se/ltdweb/AjaxData.aspx?Action=GetTrafficLines&cID=22&nonPublic=0');
			$routepoints = json_decode($routepointsRaw);
			$this->cache->file->save('routepoints_cache', $routepoints, 8035200);
		}
		
		return $routepoints;
	}
	
	public function Callback($status, $data = array()) {
		
		header('Content-type: application/json');
		
		$status = $this->config->item("cb_{$status}");
		$callback = array(
						'status_code' => $status['code'],
						//'status_string' => $status['string'],
						'data' => $data
					);
		
		echo json_encode($callback);
		die();
		
	}

	private function Distance($lat1, $lon1, $lat2, $lon2) 
	{ 
		$earthRadius = 3958.75;

	    $dLat = deg2rad($lat2 - $lat1);
	    $dLng = deg2rad($lon2 - $lon1);
	
	
	    $a = sin($dLat/2) * sin($dLat/2) +
	       cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
	       sin($dLng/2) * sin($dLng/2);
	    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
	    $dist = $earthRadius * $c;
	
	    // from miles
	    $meterConversion = 1609;
	    $geopointDistance = $dist * $meterConversion;
	
	    return $geopointDistance;
	}
	
	private function GetVehicleData()
	{
		$traffic = $this->cache->file->get('traffic_cache');
		
		if (!$traffic) {
			$trafficRaw = $this->request_model->HttpRequest('http://wp.faltcom.se/ltdweb/AjaxData.aspx?Action=UpdateTraffic&cID=22', "{'LineID':'-1','IncludeOffTraffic':'false'}");
			$traffic = json_decode($trafficRaw);
			$this->cache->file->save('traffic_cache', $traffic, 7);
		}
		
		return $traffic->Updates;
	}
	
	private function GetStopData($stopID)
	{
		$stops = $this->cache->file->get("stops/{$stopID}_cache");
		
		if (!$stops) {
			$stopsRaw = $this->request_model->HttpRequest('http://wp.faltcom.se/ltdweb/AjaxData.aspx?Action=UpdateStops&cID=22', "{'ActiveStops':'{$stopID}'}");
			$stops = json_decode($stopsRaw);
			$this->cache->file->save("stops/{$stopID}_cache", $stops, 100000);
		}
		
		return $stops->StopUpdates[0]->StopStates;
	}
	
	private function inArea($p1, $p2, $bus) {
		
		$searchEachXCoords = 0.00005;
		$radarDistance = 0.0003;
		
		$r = sqrt( pow($p1['longitude'] - $p2['longitude'], 2) + pow($p1['latitude'] - $p2['latitude'], 2) );
		$deltaY = ($p1['latitude'] - $p2['latitude']);
		$deltaX = ($p1['longitude'] - $p2['longitude']);
		$radars = floor($r / $searchEachXCoords);
		$p = array();
		
		for ($i = 1; $i <= $radars; $i++) {
			if ($p1['longitude'] < $p2['longitude']) {
				$p[$i]['latitude'] = $p1['latitude'] + ($i * $deltaY / $radars);
				$p[$i]['longitude'] = $p1['longitude'] + ($i * $deltaX / $radars);
			} else {
				$p[$i]['latitude'] = $p2['latitude'] + ($i * $deltaY / $radars);
				$p[$i]['longitude'] = $p2['longitude'] + ($i * $deltaX / $radars);
			}
		}
		
		$s = array(100, 0, 0, 0, false);
		foreach($p as $radar) {
			$diff = sqrt( pow($radar['longitude'] - $bus['longitude'], 2) + pow($radar['latitude'] - $bus['latitude'], 2) );
			$s = $s[0] > $diff ? array($diff, $radar['longitude'], $radar['latitude'], $bus['name'], $diff < $radarDistance) : $s;
			if ($diff < $radarDistance) {
				$s[4] = true;
				return $s;
			}
		}

		return $s;
		
	}
	
	public function toAscii($str, $replace=array(), $delimiter='-') {
		setlocale(LC_ALL, 'en_US.UTF8');
		
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
	
		return $clean;
	}
	
	/////////////////////////////////////////////////////////
	
	public function getNearestBusStop($routepoints, $latitude, $longitude, $line) {
		
		$trackLines = array();
		$n = 0;
		
		// If specific line was requested
		if ($line !== false) {
		
			// Loop through lines
			foreach($routepoints->Lines as $i => $currentLine) {
				
				// If current line in the loop is the requested line
				if (preg_match("#^{$line} mot .+$#", $currentLine->Name)) {
					
					// Unset unnecessarily data
					unset($currentLine->RoutePoints);
					unset($currentLine->Color);
					
					$trackLines[$n]['info'] = $currentLine;
					
					// Loop through all stops (for all lines)
					foreach($routepoints->Stops as $stop) {
						
						// If stopID belongs to the requested line
						if (in_array($stop->stopID, $currentLine->StopIDs) && !isset($stops[$stop->stopID])) {
							$stops[$stop->stopID] = $stop;
						}
					}
					
					// Unset unnecessarily data
					unset($currentLine->StopIDs);
					
					$n++;
				}
			}
			
			// If the requested line wasn't found
			if (empty($trackLines)) return null;
			
		// If specific line wasn't requested
		} else $stops = $routepoints->Stops;
		
		// Loop through all saved stops
		foreach($stops as $i => $stop) {
			
			// Rate distance and save if closer than last "record"
			$distance = sqrt(pow($stop->latitude - $latitude, 2) + pow($stop->longitude - $longitude, 2));
			if (!isset($nearestStop) || $distance < $nearestStop['distance']['distance']) {
				$nearestStop = array(
									'distance' => array(
											'distance' => $distance,
											'meters' => round($this->Distance($latitude, $longitude, $stop->latitude, $stop->longitude))
										),
									'stop' => array(
											'stopID' => $stop->stopID,
											'name' => $stop->name,
											'latitude' => (float) $stop->latitude,
											'longitude' => (float )$stop->longitude
									)
								);
			}
			
		}
		
		if ($nearestStop['distance']['meters'] > 5000) $nearestStop = array();
		
		return $nearestStop;
		
	}
	
	public function getDepartures($stopID, $lineID) {
		
		$i = 0;
		
		foreach($this->GetStopData($stopID) as $lines) {
			
			if ($lineID == 0 || $lines->Line->lineID == $lineID) {
				$buses[$i]['lineID'] = (int) $lines->Line->lineID;
				$buses[$i]['name'] = $lines->Line->name;
				$buses[$i]['line'] = (int) $lines->Line->lineNr;
				$buses[$i]['departureIn'] = ((int) substr($lines->EstimatedDeparture, 0, -3)) - time();
				if ($buses[$i]['departureIn'] < 0) $buses[$i]['departureIn'] = -1;
				
				$i++;
			}

		}
		
		foreach($this->GetRoutepoints()->Stops as $stopData) {
			if ($stopData->stopID == $stopID) {
				$stop['stopID'] = $stopData->stopID;
				$stop['name'] = $stopData->name;
				$stop['latitude'] = (float) $stopData->latitude;
				$stop['longtude'] = (float) $stopData->longitude;
			}
		}
		
		return array(
			'stop' => $stop,
			'buses' => $buses
		);
		
	}
	
	public function getNextBus($stopID, $lineIDs) {
		
		$lineIDs = explode(',', $lineIDs);
		
		// Get vehicle data
		foreach($this->GetVehicleData() as $line) {
			if (in_array($line->Line->lineID, $lineIDs)) {
				$vehicles[$line->Line->lineID] = $line->VehiclePositions;
			}
		}
		
		foreach($this->GetRoutepoints()->Lines as $line) {
			if (in_array($line->LineID, $lineIDs)) {
				foreach($line->RoutePoints as $i => $rp) {
					$routepoints[$line->LineID][$i]['latitude'] = (float) $rp->latitude;
					$routepoints[$line->LineID][$i]['longitude'] = (float) $rp->longitude;
				}
			}
		}
		
		foreach($this->GetRoutepoints()->Stops as $astop) {
			
			if ($astop->stopID == $stopID) {
				
				foreach($this->GetStopData($stopID) as $stopData) {
					if (in_array($stopData->Line->lineID, $lineIDs)) {
						
						$stop['lines'][$stopData->Line->lineID]['estimatedDeparture'] = $stopData->EstimatedDeparture;
						if ($stopData->DepartureIn >= 0)
							$stop['lines'][$stopData->Line->lineID]['departure'] = $stopData->DepartureIn;
						else {
							$stop['lines'][$stopData->Line->lineID]['departure'] = null;
							$stop['lines'][$stopData->Line->lineID]['estimatedDeparture'] = null;
						}
						
					}
				}
				
				foreach($lineIDs as $i => $line)
					if (!isset($stop['lines'][$line]))
						unset($lineIDs[$i], $routepoints[$i], $vehicles[$i]);
				
				$stop['name'] = $astop->name;
				$stop['longitude'] = (float) $astop->longitude;
				$stop['latitude'] = (float) $astop->latitude;
				break;
			}
			
		}
		
		foreach($routepoints as $lineID => $rp) {
			foreach($rp as $i => $routepoint) {
				$thisRating = sqrt(pow($routepoint['latitude'] - $stop['latitude'], 2) + pow($routepoint['longitude'] - $stop['longitude'], 2));
				
				if (!isset($routepoints[$lineID][$i - 1]) || $nearestStop[$lineID]['rating'] > $thisRating) {
					$nearestStop[$lineID] = array('index' => $i, 'rating' => $thisRating);
				}
			}
		}
		
		$nextbus = array();
		
		foreach($lineIDs as $lineID) {
			
			$rp = array();	
			
			if ($lineID % 2 == 0) {
				for($i = $nearestStop[$lineID]['index']; $i < count($routepoints[$lineID]); $i++) {
					$rp[] = $routepoints[$lineID][$i];
				}
			} else {
				for($i = $nearestStop[$lineID]['index']; $i > 0; $i--) {
					$rp[] = $routepoints[$lineID][$i];
				}
			}
			
			for($i = 0; $i < count($rp) - 1; $i++) {
				
				foreach($vehicles[$lineID] as $busrp) {
	
					$busCoords = array(
						'longitude' => $busrp->Longitude, 
						'latitude' => $busrp->Latitude, 
						'name' => $busrp->Name
					);
					
					$a = $this->inArea($rp[$i], $rp[$i + 1], $busCoords);
					
					if ($a[4]) {
						$nextbus[$lineID] = $busCoords;
						break 2;
					} else {
						$nextbus[$lineID] = false;
					}
					
				}
				
			}
	
			if (!isset($nextbus[$lineID])) {
				$nextbus[$lineID] = array(
					'name' => null
				);
			}

		}

		$data['stop']['stopID'] = $stopID;
		$data['stop']['name'] = $stop['name'];
		$data['lines'] = $nextbus;
		
		foreach($lineIDs as $lineID) {
			$data['lines'][$lineID]['departureIn'] = $stop['lines'][$lineID]['departure'];
			$data['lines'][$lineID]['estimatedDeparture'] = $stop['lines'][$lineID]['estimatedDeparture'];
		}

		return $data;
		
	}

	public function getAllStops() {
		$routepoints = $this->GetRoutepoints();
		
		$stop = array();
		foreach($routepoints->Stops as $stops) {
			$stop[] = array(
				'name' => $stops->name,
				'stopID' => $stops->stopID,
				'url' => $this->toAscii($stops->name)
			);
			$sort[] = $stops->name;
		}
		
		array_multisort($stop, $sort);

		return $stop;
	}
	
}