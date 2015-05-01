<?php

class movies extends \punymvc\Model {
    
	public function countMovies() {
		$count = 0;
		
        $stmt = $this->database()->prepare("SELECT count(*) AS total FROM movie");
		
		$stmt->execute();
		
        if ($stmt->rowCount() > 0) {
        	
        	$row = $stmt->fetchObject();
			
            $count = $row->total;
        }
		
        return $count;
	}
	
    public function listMovies($limit = 10, $offset = 0, $order = 'date_release', $direction = 'asc') {
        $movies = array();
        
        $stmt = $this->database()->prepare("SELECT * FROM movie ORDER BY $order $direction LIMIT $offset, $limit");

		try {		
			$stmt->execute(array((int)$offset, (int)$limit));
			
			if ($stmt->rowCount() > 0) {
				while ($row = $stmt->fetchObject()) {
					
					$row->poster = $this->proxifyImage($row->poster);
					
		            $movies[] = $row;
		        }	
			}
		}
		catch (PDOException $exception) {
			// something went wrong...

		}
		
        return $movies;
    }
	
	public function getMovieBySlug($slug) {
		try {
			$stmt = $this->database()->prepare("SELECT * FROM movie WHERE slug = ?");
					
			$stmt->execute($slug);
			
			if ($stmt->rowCount() > 0) {
					
				$row = $stmt->fetchObject();
				
				$row->poster = $this->proxifyImage($row->poster);	
				
				return $row;
			}
		}
		catch (PDOException $exception) {
			// something went wrong...
		}	
		
		return false;
	}
	
	public function getMovieById($movieId) {
		try {
			$stmt = $this->database()->prepare("SELECT * FROM movie WHERE id = ?");
					
			$stmt->execute($movieId);
			
			if ($stmt->rowCount() > 0) {
				$row =  $stmt->fetchObject();
				
				$row->poster = $this->proxifyImage($row->poster);
				
				return $row;
			}
		}
		catch (PDOException $exception) {
			// something went wrong...
		}	
		
		return false;
	}
	
	protected function proxifyImage($imageUri) {
		return $this->getConfig('applicationUri') . '/poster?image=' . $imageUri;
	}
	
}
