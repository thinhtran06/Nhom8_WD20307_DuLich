<?php
// app/Models/Tour.php
require_once __DIR__ . '/../../config/database.php';

class Tour {
    public static function all(){
        $db = Database::getConnection();
        $stmt = $db->query("SELECT * FROM tours");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($data){
        $db = Database::getConnection();
        $stmt = $db->prepare("INSERT INTO tours (name,type,description,price,policy,supplier) VALUES (?,?,?,?,?,?)");
        $stmt->execute([$data['name'],$data['type'],$data['description'],$data['price'],$data['policy'],$data['supplier']]);
    }
}
