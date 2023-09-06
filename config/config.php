<?php
error_reporting(-1);


$host = '127.0.0.1:3307';
$name = 'root';
$password = '';
$dbname = 'tasks';
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
    ];
$pdo = new PDO("mysql:host={$host};dbname={$dbname}", $name, $password, $opt);

