<?php

function get_pdo() {
    $dsn = 'mysql:host=localhost;port=8889;dbname=tennis;charset=utf8';
    $user = 'root';
    $password = 'root';

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        return $db;
    } catch (PDOException $e) {
        echo "エラー：" . $e->getMessage();
        die();
    }
}