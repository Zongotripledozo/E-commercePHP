<?php
namespace Core;

class Router
{
    protected $routes=[];
    protected $params=[];

    public function ad ($route, $params=[])
    {
        $route = preg_replace('/\//', '\\/', $route);

        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);
        
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);
        
        $route = '/^' . $route . '$/i';
        
        $this->routes[$route]=$params;
    }
    public function getRoutes()
    {
        return $this->routes;
    }

    public function match($url)
    {
        foreach ($this->routes as $route => $params){
            if (preg_match($route,$url,$matches)){
                foreach ($matches as $key => $match){
                    if(is_string($key)){
                        $params[$key]=$match;
                    }
                }
                $this->params = $params;
                return true;
            }

        }
        return false;

    }

    public function getParams()
    {
        return $this->params;
    }


    public function dispatch($url)
    {
        $url=$this->removeQueryStringVaribles($url);
        if ($this->match($url)){
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            $controller = $this->getNamespace() . $controller;
            if (class_exists($controller)){
                $controller_object = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);
                if (preg_match('/action$/i',$action)==0){
                    $controller_object->$action();
                }
            }
        }
    }


    protected function converToCamelCase($string){
        return lcfirst($this->convertToStudlyCaps($string));
    }

    protected function converToStrudlyCaps($string){
        return str_replace(' ','',ucwords(str_replace('-',' ',$string)));
    }

    protected function removeQueryStringVaribles($url){
        if ($url != '') {
            $parts = explode('&', $url, 2);
            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }
        return $url;
    }
    

    protected function getNamespace(){
        $namespace='App\Controllers\\';
        if(array_key_exists('namespace',$this->params)){
            $namespace.=$this->params['namespace'].'\\';
        }
        return $namespace;
    }
}

?>