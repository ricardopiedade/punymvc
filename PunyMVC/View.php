<?php

namespace punymvc;

class View {

	public function display($template, array $data = array()) {
        $path = Config::get('PUNYMVC_APPLICATION_DIR') . 'views' . DIRECTORY_SEPARATOR . $template . '.tpl';
        
        if (file_exists($path) && is_readable($path)) {
            return $this->process($path, $data); 
        }
		
        return false;
	}
	
	protected function process($path, array $data = array()) {
	    extract($data, EXTR_OVERWRITE);
	    ob_start();
        include $path;
        return ob_get_clean();
	}

}