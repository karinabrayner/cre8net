<?php

// Inicia a sessão
session_start();

// Conecta ao banco
require_once "conexao.php";


// ==========================================
// RECEBE OS DADOS DO FORMULÁRIO
// ==========================================

$email = $_POST["email"] ?? "";
$senha = $_POST["senha"] ?? "";


// ==========================================
// VERIFICA SE OS CAMPOS ESTÃO PREENCHIDOS
// ==========================================

if (empty($email) || empty($senha)) {

    die("Preencha o e-mail e a senha.");

}


// ==========================================
// PROCURA O USUÁRIO NO BANCO
// ==========================================

$sql = "
    SELECT
        id,
        usuario,
        email,
        senha

    FROM usuarios

    WHERE email = ?
";


$stmt = $conn->prepare($sql);


// Verifica se a consulta foi preparada corretamente
if (!$stmt) {

    die("Erro ao preparar a consulta.");

}


$stmt->bind_param(
    "s",
    $email
);


$stmt->execute();

$resultado = $stmt->get_result();


// ==========================================
// VERIFICA SE O USUÁRIO EXISTE
// ==========================================

if ($resultado->num_rows === 1) {

    $usuario = $resultado->fetch_assoc();


    // ======================================
    // VERIFICA A SENHA
    // ======================================

    if (
        password_verify(
            $senha,
            $usuario["senha"]
        )
    ) {

        // ==================================
        // LOGIN REALIZADO
        // ==================================

        $_SESSION["usuario_id"] =
            $usuario["id"];

        $_SESSION["usuario"] =
            $usuario["usuario"];

        $_SESSION["email"] =
            $usuario["email"];


        // Regenera o ID da sessão
        // por segurança
        session_regenerate_id(true);


        // ==================================
        // MANDA PARA A HOME
        // ==================================

        header(
            "Location: Home.html"
        );

        exit;

    }

}


// ==========================================
// LOGIN INVÁLIDO
// ==========================================

echo "
<!DOCTYPE html>

<html lang='pt-BR'>

<head>

    <meta charset='UTF-8'>

    <title>Erro de Login</title>

    <style>

        body {
            font-family: Arial, sans-serif;

            background-color: rgb(240, 218, 178);

            display: flex;

            justify-content: center;

            align-items: center;

            min-height: 100vh;

            margin: 0;
        }

        .erro {

            background-color: white;

            padding: 35px;

            border-radius: 15px;

            text-align: center;

            box-shadow:
                0 10px 20px rgba(0,0,0,.15);

        }

        h1 {

            color: rgb(150, 180, 219);

        }

        p {

            color: #555;

        }

        a {

            display: inline-block;

            margin-top: 15px;

            padding: 12px 20px;

            background-color:
                rgb(150, 180, 219);

            color: white;

            text-decoration: none;

            border-radius: 8px;

            font-weight: bold;

        }

        a:hover {

            background-color:
                rgb(120, 160, 205);

        }

    </style>

</head>

<body>

    <div class='erro'>

        <h1>Ops!</h1>

        <p>
            E-mail ou senha incorretos.
        </p>

        <a href='Login.html'>
            Voltar para o Login
        </a>

    </div>

</body>

</html>
";


// Fecha a conexão
$stmt->close();

$conn->close();

?>