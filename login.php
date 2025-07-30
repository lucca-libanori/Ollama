<?php
require_once "conexao.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);
    if (isset($_POST['nome']) && isset($_POST['senha'])) {

        $nome = $_POST['nome'];
        $senha = $_POST['senha'];
        $injection = mysqli_prepare($conn, "SELECT senha FROM usuario WHERE nome = ? LIMIT 1");
        mysqli_stmt_bind_param($injection, "s", $nome);
        mysqli_stmt_execute($injection);
        $result = mysqli_stmt_get_result($injection);

        if ($row = mysqli_fetch_assoc($result)) {
            if ($senha === $row['senha']) {
                echo json_encode([
                    "status" => "success",
                    "redirect" => "http://localhost:5000/"
                ]);
                exit;
            } else {
                echo json_encode([
                    "status" => "error",
                    "message" => "Senha incorreta"
                ]);
                exit;
            }
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Usuário não encontrado"
            ]);
            exit;
        }
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Preencha todos os campos"
        ]);
        exit;
    }
}
?>