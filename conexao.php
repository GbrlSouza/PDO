<?php 
// Testes com PDO
try { $pdo = new PDO("mysql:host=localhost; dbname=pdo", "root", ""); }
catch (PDOException $e) { echo "Erro na conexão: " . $e->getMessage(); }
catch (Exception $e) { echo "Erro genérico: " . $e->getMessage(); }

// CRUD - Create, Read, Update, Delete
// Create - Insert
// Read - Select
// Update - Update
// Delete - Delete

// Create
$res = $pdo -> prepare("insert into pessoa (nome, email, telefone) values (:nome, :email, :telefone)");
$res -> bindValue(":nome", "teste");
$res -> bindValue(":email", "teste");
$res -> bindValue(":telefone", "teste");
$res -> execute();

// Delete
$res = $pdo -> prepare("delete from pessoa wherer id = :id");
$res -> bindValue(":id", "1");
$res -> execute();

// Update
$res = $pdo -> prepare("update pessoa set nome = :nome, email = :email, telefone = :telefone where id = :id");
$res -> bindValue(":nome", "teste");
$res -> bindValue(":email", "teste");
$res -> bindValue(":telefone", "teste");
$res -> bindValue(":id", "1");
$res -> execute();

// Read
$res = $pdo -> prepare("select * from pessoa where id = :id");
$res -> bindValue(":id", "1");
$res -> execute();

// Fetch
$dados = $res -> fetch(PDO::FETCH_ASSOC);

// Show data
foreach ($dados as $key => $value) { echo $key . ": " . $value . "<br>"; }
