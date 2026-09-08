<?php

session_start();

require_once "conexao.php";


header(
    "Content-Type: application/json"
);


// ==========================================
// VERIFICA LOGIN
// ==========================================

if (!isset($_SESSION["usuario_id"])) {

    echo json_encode([
        "sucesso" => false,
        "mensagem" => "Você precisa estar logado."
    ]);

    exit;

}


$usuario_id =
    $_SESSION["usuario_id"];


$arte_id =
    intval($_POST["arte_id"]);


// ==========================================
// VERIFICA SE JÁ DEU LIKE
// ==========================================

$sql = "
    SELECT id
    FROM likes
    WHERE usuario_id = ?
    AND arte_id = ?
";


$stmt =
    $conn->prepare($sql);


$stmt->bind_param(
    "ii",
    $usuario_id,
    $arte_id
);


$stmt->execute();


$resultado =
    $stmt->get_result();


if ($resultado->num_rows > 0) {


    // ======================================
    // REMOVE LIKE
    // ======================================

    $sqlDelete = "
        DELETE FROM likes

        WHERE usuario_id = ?

        AND arte_id = ?
    ";


    $stmtDelete =
        $conn->prepare($sqlDelete);


    $stmtDelete->bind_param(
        "ii",
        $usuario_id,
        $arte_id
    );


    $stmtDelete->execute();


    $curtido = false;


} else {


    // ======================================
    // ADICIONA LIKE
    // ======================================

    $sqlInsert = "
        INSERT INTO likes
        (usuario_id, arte_id)

        VALUES (?, ?)
    ";


    $stmtInsert =
        $conn->prepare($sqlInsert);


    $stmtInsert->bind_param(
        "ii",
        $usuario_id,
        $arte_id
    );


    $stmtInsert->execute();


    $curtido = true;

}


// ==========================================
// NOVO CONTADOR
// ==========================================

$sqlCount = "
    SELECT COUNT(*) AS total

    FROM likes

    WHERE arte_id = ?
";


$stmtCount =
    $conn->prepare($sqlCount);


$stmtCount->bind_param(
    "i",
    $arte_id
);


$stmtCount->execute();


$resultadoCount =
    $stmtCount->get_result();


$dados =
    $resultadoCount->fetch_assoc();


echo json_encode([

    "sucesso" => true,

    "curtido" => $curtido,

    "total" => $dados["total"]

]);

?>