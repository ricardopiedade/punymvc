<?php

/*
 * 
 * Represents a View
 *  
 * Provides view parsing functiuonality
 * 
 */


 
namespace punymvc;

class View {

    /*
     *
     * validates the view path and processes it, returning its output on success 
     * 
     */
    public function display($template, array $data = array()) {
        $path = Config::get('PUNYMVC_APPLICATION_DIR') . 'views' . DIRECTORY_SEPARATOR . $template . '.tpl';
        
        if (file_exists($path) && is_readable($path)) {
            return $this->process($path, $data); 
        }
        
        error_log("PunyMVC Error: the specified view does nos exist or is not readable: " . $template);
        return false;
    }
    
    /*
     * Processes a view
     * 
     * extracts the $data array into variables using keys as variable names
     * 
     * processes view content using output buffering mechanism and returns the output
     * 
     */
    protected function process($path, array $data = array()) {
        extract($data, EXTR_OVERWRITE);
        ob_start();
        include $path;
        return ob_get_clean();
    }

}