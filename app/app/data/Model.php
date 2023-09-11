<?php

namespace App\data;

 abstract class Model{
    protected Repository $db;
    public function __construct()
    {
        $this->db = Repository::GetRepository();
    }


}