<?php

namespace punymvc;

abstract class Model extends Loader{

    public function database($namedInstance = null) {
        return $namedInstance == null ? Database::get() : Database::get($namedInstance);
    }   
}