<?php

class proxy extends \punymvc\Controller{
	
	public function poster() {
		
		$imageUri = $this->request->get('image');
		
		$curl = curl_init();
		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_HEADER, FALSE);	
		curl_setopt($curl, CURLOPT_URL, $imageUri);
		
		$image= curl_exec($curl);
		
		$this->response->setContentType(curl_getinfo($curl, CURLINFO_CONTENT_TYPE));
		$this->response->setBody($image);
	}

}
