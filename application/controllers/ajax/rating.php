<?php

class rating extends Controller{
    
    public function endpoint() {
        $this->response->setContentType('application/json');
        $this->response->setBody(json_encode(array('cenas' => 'coisas')));
    }
    
}
