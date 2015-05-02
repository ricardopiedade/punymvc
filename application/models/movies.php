<?php


/*
 * Model class to retrieve upcoming movies from a database
 * 
 */
 
class movies extends \punymvc\Model {
 
    /* textual months for numeric / textual translation */   
    protected $months = array('jan', 'feb', 'mar', 'apr', 'may', 'jun', 'jul', 'aug', 'sep', 'oct', 'nov', 'dec');
    
    /*
     * lists upcoming movies
     * optional $month param filters movies by release date month
     */
    public function listMovies($month = null) {
        $movies = array();
        $params = array();

        $sqlStatement = "SELECT * FROM movie ";
        
        if (is_numeric($month)) {
            $sqlStatement .= " WHERE month(date_release) = ?";
            $params[] = $month;
        }
        
        $sqlStatement .= " ORDER BY date_release ASC";

        try {
            $stmt = $this->database()->prepare($sqlStatement);
                   
            $stmt->execute($params);
            
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetchObject()) {
                    
                    $row->poster = $this->proxifyImage($row->poster);
                    
                    $movies[] = $row;
                }
            }
        }
        catch (PDOException $exception) {
            error_log('PunyMVC Error: could not execute query. ' . $exception->getMessage());
        }

        return $movies;
    }
    
    /* gets a movie from the database by its url slug */
    public function getMovieBySlug($slug) {
        try {
            $stmt = $this->database()->prepare("SELECT * FROM movie WHERE slug = ?");
                    
            $stmt->execute(array($slug));
            
            if ($stmt->rowCount() > 0) {
                    
                $row = $stmt->fetchObject();
                
                $row->poster = $this->proxifyImage($row->poster);   
                
                return $row;
            }
        }
        catch (PDOException $exception) {
            error_log('PunyMVC Error: could not execute query. ' . $exception->getMessage());
        }   
        
        return false;
    }
    
    /* gets the list of months that have movie releases*/
    public function getMovieMonths() {
        $months = array();
        try {
            $stmt = $this->database()->prepare("SELECT DISTINCT month(date_release) as numeric_month FROM movie ORDER BY month(date_release)");
                    
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                while ($row =  $stmt->fetchObject()) {
                    $row->text_month = $this->getTextMonth($row->numeric_month);
                
                    $months[] =  $row;                    
                }
            }
        }
        catch (PDOException $exception) {
            error_log('PunyMVC Error: could not execute query. ' . $exception->getMessage());
        }   

        return $months;
    }

    /* changes the original movie image url to use the application proxy
     * this is because IMDB does not let me hotlink their images from the browser
     */    
    protected function proxifyImage($imageUri) {
        return $this->getConfig('applicationUri') . '/poster?image=' . $imageUri;
    }
    
    /* gets the numeric equivalente of a textual month */
    public function getNumericMonth($textMonth) {
        $index = array_search($textMonth, $this->months);
        return ++$index; 
    }
    
    /* gets the textual equivalente of a numeric month */
    protected function getTextMonth($numericMonth) {
        return $this->months[$numericMonth - 1];
    }
    
}
