<?php

require_once "config/Database.php";

// Instancia a classe
$database = new Database();

// Tenta conectar
$conn = $database->getConnection();

// Verifica se conectou
if($conn){
    echo "Conexão realizada com sucesso!";
}