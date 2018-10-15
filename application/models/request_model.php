<?php

class Request_Model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }
	
	public function HttpRequest($url, $payload = '') {
	
		// Get saved routepoints
		$sessionID = $this->cache->file->get('ASPSessionID');
	
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_COOKIE, "ASP.NET_SessionId={$sessionID}");
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);  
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT,  50);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
		    'Content-Type: application/json',                                                                                
		    'Content-Length: ' . strlen($payload))                                                                       
		);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 
		$response = curl_exec($ch);
	
		// If request timed out
		if (curl_errno($ch)) $this->API_Model->Callback('request_timeout');
	
		// If last session id was invalid
		if ($response == 'null') {
	
			$sessionID = $this->_GetSessionCookie();
	
			// Save new session id
			$this->cache->file->save('ASPSessionID', $sessionID, 3600);
			$this->api_model->Callback('session_cookie');
	
		}
	
		return $response;
	
	}

	private function _GetSessionCookie() {
	
		global $cachefile, $timeoutretry, $curltimeout;
		$ch = curl_init();
	                          
		curl_setopt ($ch, CURLOPT_URL, 'http://wp.faltcom.se/ltdweb/linetrafficmap.aspx?cID=22');
		curl_setopt($ch,CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.72 Safari/537.36');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT,  $curltimeout);
		curl_setopt($ch, CURLOPT_VERBOSE, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		 
		$response = curl_exec($ch);
	
		// If request timed out
		if (curl_errno($ch)) $this->api_model->Callback('request_timeout');
	
		$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$header = substr($response, 0, $header_size);
		$body = substr($response, $header_size);
	
		$cookie = preg_match('#Set-Cookie: ASP.NET_SessionId=([a-z0-9]+);#', $header, $match);
		curl_close($ch);
	
		return $match[1];
	
	}
	
}

interface iAPI_Model
{
    public function Callback($status);
}