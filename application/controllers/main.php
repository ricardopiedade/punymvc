<?php

class main extends \punymvc\Controller{
	
	public function index() {
		$viewData = array();
		
		$this->model('movies');
		
		$count = $this->movies->countMovies();
		$viewData['count'] = $count;
		
		if ($count > 0) {
			$viewData['list'] = $this->movies->listMovies();
		}

		$this->setView('list', $viewData);
	}
	
	public function movie($slug) {
		$viewData = array();
		
		// get movie from database
		$this->model('movies');
		
		if ($movie = $this->movies->getMovieBySlug($slug)) {
			$viewData['movie'] = $movie;
			
			// get imdb and rotten tomatoes ratings		
			$this->library('omdb');
			if ($movieInfo = $this->omdb->getMovie($movie->id)) {
				$viewData['movieInfo'] = $movieInfo;
			}
		}
		
		$this->setView('movie', $viewData);
	}
	
	protected function setView($view, array $viewData = array()) {
		$this->response->view('header');
		$this->response->view($view, $viewData);
		$this->response->view('footer');
	}
}
