<?php

class month extends \punymvc\Controller {
        
    public function movies($month) {

        $viewData = array();
        
        $this->model('movies');
        
        $numericMonth = $this->movies->getNumericMonth($month);

        $viewData['list']   = $this->movies->listMovies($numericMonth);
        $viewData['months'] = $this->movies->getMovieMonths(); 

        $this->response->view('list', $viewData);
    }     
}
