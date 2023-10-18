<?php

namespace Cores;

Class View{

    public static function render($view, $args=[])
    {
        extract($args, EXTR_SKIP);
        $file=dirname(__DIR__)."/App/Views/$view";
        if (is_readable($file)){
            require $file;
        }else{
            echo"file not found";

        }
    }
    public static function rednerTemplate($template,$arg=[])
    {
        static $twig =null;
        if($twig ===NULL){
            $loader=new \Twig_Loader_Filesystem(dirname(__DIR__).'/App/View');
            $twig=new \Twig_Environment ($loader);
        }
        echo $twig->render($template, $args);
    }
}

?>