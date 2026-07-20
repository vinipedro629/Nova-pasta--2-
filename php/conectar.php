<?php

// =======================================
// CONEXÃO COM O BANCO DE DADOS
// =======================================

// Dados da conexão
$host = "127.0.0.1";
$porta = 3307;
$usuario = "root";
$senha = "";
$banco = "meu_caderno";

// Criar conexão
$conexao = new mysqli($host, $usuario, $senha, $banco, $porta);

// Verificar conexão
if ($conexao->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conexao->connect_error);
}

// Definir charset
$conexao->set_charset("utf8");

?>