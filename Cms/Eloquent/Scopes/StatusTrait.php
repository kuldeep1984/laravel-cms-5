<?php

namespace Cms\Eloquent\Scopes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of StatusTrait
 *
 * @author user
 */
trait StatusTrait {

    /**
     * Boot the scope
     */
    public static function bootStatusTrait() {
        
        
        
        static::addGlobalScope(new StatusScope);
        
        
    }

    /**
     * Get the name of column for appllying the scope
     */
    public function getStatusColumn() {

        return defined('static::STATUS_COLUMN') ? static::STATUS_COLUMN : 'status';
    }

    /**
     * Get fully qualified column name for applying the scope
     */
    public function getQualifiedStatusColumn() {
        return $this->getTable() . '.' . $this->getStatusColumn();
    }

    /**
     * Get the query builder without the scope applied.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withAllStatus() {
        return with(new static)->newQueryWithoutScope(new StatusScope);
    }

}
