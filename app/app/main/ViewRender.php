<?php
namespace App\main;

use Exception;

class ViewRender{

    
    public function __construct(protected string $view,protected array $params =[]) {
        
    }


    public static function make(string $view, array $params = []): static
    {
        return new static($view, $params);
    }

    public function render():bool|string{

        $viewPath = VIEW_PATH .'/' . $this->view .'.php';
        if(!file_exists($viewPath)){
            throw new Exception();
        }
        foreach($this->params as $propKey => $propValue)
        {
            $$propKey = $propValue;// Creating a new varibles thats value is the  it prop value to enter in DOM 
        }
        ob_start();
        include $viewPath;
        return (string) ob_get_clean();
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function __get(string $name)
    {
        return $this->params[$name] ?? null;
    }


    

}