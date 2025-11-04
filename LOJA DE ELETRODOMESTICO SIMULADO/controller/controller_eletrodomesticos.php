<?php
require_once __DIR__ . "/../model/model_eletrodomestico.php";

// Corrigido: inicia a sessão apenas se ainda não houver uma ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// CADASTRAR ELETRODOMESTICO
if (isset($_POST["cadastrar_eletrodomestico"])) {
    $eletro = new Eletrodomestico();
    $resultado = $eletro->cadastrar_eletrodomestico(
        $_POST["nome"],
        $_POST["descricao"],
        $_POST["fornecedor"],
        $_POST["categoria"],
        $_POST["potencia"],
        $_POST["consumo_energetico"],
        $_POST["garantia"],
        $_POST["prioridade_reposicao"],
        $_SESSION['usuario']["USU_ID"]
    );

    if ($resultado) {
        echo "<script>
                alert('Eletrodoméstico cadastrado com sucesso!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao cadastrar eletrodoméstico!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    }
    exit();
}

// BUSCAR DADOS PARA EDITAR ELETRODOMESTICO
else if (isset($_GET["acao"]) && $_GET["acao"] == "editar_eletrodomestico") {
    $eletro = new Eletrodomestico();
    $resultados = $eletro->buscar_eletrodomestico_pelo_id($_GET["id"]);

    if (!empty($resultados)) {
        $eletro_editar = $resultados[0];
    } else {
        echo "<script>
                alert('Eletrodoméstico não encontrado!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
        exit();
    }
}

// EDITAR ELETRODOMESTICO
if (isset($_POST["editar_eletrodomestico"])) {
    $eletro = new Eletrodomestico();
    $resultado = $eletro->editar_eletrodomestico(
        $_POST["nome"],
        $_POST["descricao"],
        $_POST["fornecedor"],
        $_POST["categoria"],
        $_POST["potencia"],
        $_POST["consumo_energetico"],
        $_POST["garantia"],
        $_POST["prioridade_reposicao"],
        $_GET["id"],
        $_SESSION['usuario']["USU_ID"]
    );

    if ($resultado) {
        echo "<script>
                alert('Eletrodoméstico atualizado com sucesso!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao atualizar eletrodoméstico!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    }
    exit();
}

// EXCLUIR ELETRODOMESTICO
else if (isset($_GET["acao"]) && $_GET["acao"] == "excluir_eletrodomestico") {
    $eletro = new Eletrodomestico();
    $resultado = $eletro->excluir_eletrodomestico($_GET["id"], $_SESSION['usuario']['USU_ID']);

    if ($resultado) {
        echo "<script>
                alert('Eletrodoméstico excluído com sucesso!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    } else {
        echo "<script>
                alert('Erro ao excluir eletrodoméstico!');
                window.location.href='../view/cadastro_eletrodomestico.php';
            </script>";
    }
    exit();
}

// FILTRAR ELETRODOMESTICOS
else if (isset($_POST["filtrar_eletrodomesticos"])) {
    $eletro = new Eletrodomestico();
    $resultados = $eletro->filtrar_eletrodomestico($_POST["campo"]);
} else {
    $eletro = new Eletrodomestico();
    $resultados = $eletro->listar_eletrodomesticos();
}
?>