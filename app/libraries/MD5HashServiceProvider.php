<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD5HashServiceProvider
 *
 * @author user
 */
class MD5HashServiceProvider extends Illuminate\Support\ServiceProvider{
    //put your code here
    
    public function register(){
        $this->app['hash'] = $this->app->share(function(){
            return new MD5Hasher();
        });
    }
    
    public function provides(){
        return array('hash');
    }
}
