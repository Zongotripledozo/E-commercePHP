<?php

namespace App\Models;

use PDO;

class User extends \Core\Model {
    public static function getAll() {
        $db = static::getDB();
        $stmt = $db->query("SELECT * FROM produit;");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
