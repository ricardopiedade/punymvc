<?php

/*
 * 
 * The Model class extends the Loader class to provide access to other models and libraries inside user-created models
 * It provides a method to get a database singleton
 * 
 */

namespace punymvc;

abstract class Model extends Loader{

    /*
     * gets a database object singleton
     * optional parameter $namesInstance allows for multiple instances
     */
    public function database($namedInstance = null) {
        return $namedInstance == null ? Database::get() : Database::get($namedInstance);
    }   
}