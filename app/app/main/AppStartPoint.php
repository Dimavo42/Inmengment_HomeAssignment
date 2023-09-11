<?php

namespace App\main;
use App\router\Router;
use Error;

class AppStartPoint {

    
    public function __construct(protected Router $router,protected array $request) 
    {
        $this->pullPictureFromApi();
    }

    public function run()
    {
        try{
        echo $this->router->reslove(
            $this->request['uri'],
            strtolower($this->request['method'])
        );
        }catch(Error $e){
            http_response_code(404);
        }
    }

    private function pullPictureFromApi()
    {
        $imageUrl = 'https://cdn2.vectorstock.com/i/1000x1000/23/81/default-avatar-profile-icon-vector-18942381.jpg';
        $imageContent = file_get_contents($imageUrl);
        $imageFullPath = STORAGE_PATH .'/' .'image.png';
        if(  file_put_contents($imageFullPath,$imageContent) === false )
        {
            throw new Error();
        }
    }


}