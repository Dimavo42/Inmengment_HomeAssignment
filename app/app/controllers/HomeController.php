<?php

namespace App\controllers;

use App\data\Model;
use App\main\ViewRender;


class HomeController extends Model
{
    //Home Controller
    public function index(): string
    {
        $getAllUsersQuery = 'SELECT Users.name,Posts.content 
        FROM Posts LEFT JOIN Users 
        ON Posts.user_id = Users.id  
        WHERE Posts.is_active = 1 ';
        $allUsers = $this->db->query($getAllUsersQuery)->fetchAll();
        return ViewRender::make('Home/index', ['allUsers' => $allUsers]);
    }
}
