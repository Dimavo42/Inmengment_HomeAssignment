<?php
namespace App\controllers;

use App\data\Model;
use App\main\ViewRender;

class TableController extends Model{
    //Table controler
    public function index():string
    {
        $queryToDoDB="SELECT DATE(created_at) AS month, 
        Time(created_at) as time,
        COUNT(*) AS count  FROM Posts 
        GROUP BY month,time";
        $Posts = $this->db->query($queryToDoDB)->fetchAll();
        return ViewRender::make('Table/index',['tableResult'=>$Posts]);
    }
}