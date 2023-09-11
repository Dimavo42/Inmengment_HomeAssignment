<?php 
namespace App\controllers;
use App\data\Model;
use App\main\ViewRender;


class UserController extends Model{
    //Birthday == then return the query
    
    public function index(): string
    {
        $querryString=$_SERVER['QUERY_STRING'];
        $querryExtrected=explode('=',$querryString)[1];
        $stmt = "SELECT posts p.* FROM posts as p 
        INNER JOIN Users as u  on p.user_id = u.id 
        WHERE Month(u.birthday = $querryExtrected) ORDER BY DESC 
        LIMIT 1";
        $userBirthday = $this->db->query($stmt)->fetch();
        return ViewRender::make('User/index',['birthday'=> $userBirthday]);
    }

}