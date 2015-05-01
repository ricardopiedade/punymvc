<?php

class movies extends \punymvc\Controller{
    	
    public function listMovies($offset = 0) {
    	
		$this->model('movies');
		
		$list = $this->movies->listMovies($this->getConfig('listItemsPerPage'), $offset);
		
        $this->response->setContentType('application/json');
		
		$response = array(
			'offset' => $offset,
			'count'  => $count,
			'data'   => $this->response->view('index')
		)
		
        $this->response->setBody(json_encode($list));
    }
    
}
