<?php

namespace Cms\Eloquent\Scopes;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VersionTrait
 *
 * @author user
 */
trait VersionTrait {

    /**
     * Boot the scope
     */
    public static function bootVersionTrait() {
        
        
        
        static::addGlobalScope(new VersionScope);
        
        
    }

    /**
     * Get the name of column for appllying the scope
     */
    public function getVersionColumn() {

        return defined('static::VERSIOIN_COLUMN') ? static::STATUS_COLUMN : 'version';
    }

    /**
     * Get fully qualified column name for applying the scope
     */
    public function getQualifiedVersionColumn() {
        return $this->getTable() . '.' . $this->getVersionColumn();
    }

    /**
     * Get the query builder without the scope applied.
     * 
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function withAllVersion() {
        return with(new static)->newQueryWithoutScope(new VersionScope);
    }

}
