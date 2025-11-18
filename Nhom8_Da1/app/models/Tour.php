<?php
require_once __DIR__ . '/../../config/database.php';

class Tour {

    public static function all() {
        $pdo = Database::getConnection();
        $stmt = $pdo->query("SELECT * FROM tours");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("SELECT * FROM tours WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
