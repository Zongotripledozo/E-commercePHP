<?php

namespace App\Controllers;
use \Core\View;
use APP\Models\User;
class Catalog extends \Core\Controller{

    public function productAction(){
        View::renderTemplate('Catalog/index.html',[
            'produit'=> User::getAll()
        ]);
    }
}

?>