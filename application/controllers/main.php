<?php

class main extends \punymvc\Controller {
    
    /*
     * shows the main upcoming mvoie list
     */  
    public function index() {
        // an array of data to pass to the view
        $viewData = array();
        
        // load the movie model
        $this->model('movies');

        // get the current month select it by default in the view    
        $month = (int) date("m", time());
        
        // get the months with movie releases for the interface filters
        $viewData['months'] = $this->movies->getMovieMonths();
        
        // load the movies for the default month
        $viewData['list'] = $this->movies->listMovies($month);
        
        // pass the default month filter to the view
        $viewData['filter_month']  = $month; 

        // and finally load the view
        $this->setView('list', $viewData);
    }
    
    /*
     * shows the movie detail
     */ 
    public function movie($slug) {
        // an array of data to pass to the view
        $viewData = array();
        
        // load the movie model
        $this->model('movies');
        
        // get the movie by the url slug
        if ($movie = $this->movies->getMovieBySlug($slug)) {
            // add the movie to the view data
            $viewData['movie'] = $movie;
            
            // get imdb and rotten tomatoes ratings using the omdb api     
            $this->library('omdb');
            if ($movieInfo = $this->omdb->getMovie($movie->id)) {
                // add the movie information to the view data
                $viewData['movieInfo'] = $movieInfo;
            }
        }
        
        // and finally load the view
        $this->setView('movie', $viewData);
    }

    /* 
     * handler for the "not found" response
     */     
    public function notfound() {
        $this->response->setStatus(404);
        $this->setView('notfound', array('message' => 'Ooops... seems like that movie does not exist yet.'));
    }
    
    /*
     * this method wraps the content view with the header and footer
     */
    protected function setView($view, array $viewData = array()) {
        $this->response->view('header', $viewData);
        $this->response->view($view, $viewData);
        $this->response->view('footer', $viewData);
    }
}
