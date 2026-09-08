<?php

$servidor = "localhost";
$usuario = "root";
$senha = "ifsp";
$banco = "cre8net";

// Cria a conexão com o MySQL
$conn = new mysqli(
    $servidor,
    $usuario,
    $senha,
    $banco
);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar com o banco de dados: " . $conn->connect_error);
}

// Define o padrão de caracteres
$conn->set_charset("utf8mb4");

?>