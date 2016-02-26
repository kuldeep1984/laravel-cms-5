<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MD5Hasher
 *
 * @author user
 */
class MD5Hasher implements Illuminate\Contracts\Hashing\Hasher{
    //put your code here
    
    public function make($value, array $options = array()) {
        return hash('md5', $value);
    }
    
    public function check($value, $hashedValue, array $options = array()) {
        return $this->make($value) === $hashedValue;
    }
    
    public function needsRehash($hashedValue, array $options = array()) {
        
        return false;
    
    }
}
