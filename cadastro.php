<?php
require_once "conexao.php";

$nome = $_POST["nome"];
$senha = $_POST["senha"];
$conf_senha = $_POST["conf_senha"];

if (empty($nome)) {
    echo "Errado, sem nome";
    exit;
}
if (empty($senha) || empty($conf_senha)){
    echo "Preencha todos os campos";
    exit;
}

if ($senha !== $conf_senha){
    echo "Senhas diferentes";
    exit;
}

$sql = "INSERT INTO usuario (nome, senha) VALUES ('$nome', '$senha')";
$ret = mysqli_query($conn, $sql);

if ($ret === TRUE) {
    echo "Cadastro feito com sucesso!";
} else {
    echo "erro: " . mysqli_error($conn);
}
?>