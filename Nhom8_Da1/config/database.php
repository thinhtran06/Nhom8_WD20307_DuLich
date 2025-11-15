<?php
// config/database.php

class Database {
    private static $connection = null;

    public static function getConnection(){
        if(self::$connection === null){
            try {
                self::$connection = new PDO(
                    "mysql:host=localhost;dbname=bk_da1;charset=utf8",
                    "root", // username
                    ""      // password
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
