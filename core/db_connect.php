<?php

$host = '127.0.01:3306';
$db   = 'bootcamp';
$user = 'root';
$pass = '0bloM1@20';
$charset = 'utf8mb4';

 $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
 $options = [
 PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
 PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
 PDO::ATTR_EMULATE_PREPARES   => false,
 ];
 try {
     $pdo = new PDO($dsn, $user, $pass, $options);
      var_dump($pdo);
 } catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int)$e->getCode());
 }

// $conn = mysqli_connect($host, $user, $pass);

// // Check connection
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }
// echo "Connected successfully";
// ?>