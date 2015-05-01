<?php

class omdb extends \punymvc\Library {
	
	protected $endpoint = null;
	
	protected $curl = null;
	
	public function __construct() {
		$this->endpoint = $this->getConfig('OmdbEndpoint');
		
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($this->curl, CURLOPT_HEADER, FALSE);	
	}
	
	public function getMovie($imdbId) {
		return $this->request('plot=full&tomatoes=true&i=' . $imdbId);
	}
	
	protected function request($uri) {
		$response = false;

		curl_setopt($this->curl, CURLOPT_URL, $this->endpoint . $uri);
	
		if ($result = curl_exec($this->curl)) {
			$response = json_decode($result);
		}
			
		curl_close($this->curl);
	
		return $response;	
	}

}
