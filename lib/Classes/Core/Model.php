<?php
/**
 * Name: Class Model
 * Purpose: Connect to database and set default settings.
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2018/12/25
 * Update Time: 2019/01/04
 */
class Model extends Database
{
    private $model;
    private $table;

    function __construct(){
        // connect to database.
        parent::__construct();
        // set model name.
        $this->model = get_class($this);
        $this->model = rtrim($this->model, 'Model');
        // set table name.
        $this->table = strtolower($this->model);
    }
}
?>