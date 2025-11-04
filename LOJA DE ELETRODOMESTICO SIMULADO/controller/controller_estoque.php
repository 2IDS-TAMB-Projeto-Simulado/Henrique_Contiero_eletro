<?php
ob_start(); // Garante que não haja problemas de cabeçalho ou sessão duplicada

require_once __DIR__ . "/../model/model_estoque.php";
require_once __DIR__ . "/../model/model_eletrodomestico.php";

// Corrigido: inicia a sessão apenas se ainda não houver uma ativa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['botao_movimentar'])) {
    $estoque = new Estoque();
    $tipo = strtoupper($_POST['acao_estoque']); // ENTRADA ou SAIDA
    $quantidade_movimentacao = $_POST['qtd_movimentacao'];
    $eletro_id = $_POST['eletro_id'];
    $data_movimentacao = $_POST['data_movimentacao'];

    $success = $estoque->movimentar_estoque(
        $eletro_id,
        $quantidade_movimentacao,
        $tipo,
        $_SESSION['usuario']['USU_ID'],
        $data_movimentacao
    );

    if ($success) {
        // Verificar alerta após movimentação
        if ($tipo == 'SAIDA' && $estoque->verificar_alerta($eletro_id)) {
            echo "<script>
                    alert('Movimentação realizada com sucesso! Alerta: Estoque abaixo do limite mínimo.');
                    window.location.href = './../view/gestao_estoque.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Movimentação realizada com sucesso!');
                    window.location.href = './../view/gestao_estoque.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Falha ao realizar movimentação! Verifique se há estoque suficiente para saída.');
                window.location.href = './../view/gestao_estoque.php';
              </script>";
    }
}

// Listar eletrodomésticos para gestão de estoque (ordenados alfabeticamente)
$eletro = new Eletrodomestico();
$eletrodomesticos = $eletro->listar_eletrodomesticos();
usort($eletrodomesticos, function($a, $b) {
    return strcmp($a['ELETRO_NOME'], $b['ELETRO_NOME']);
});

ob_end_flush(); // Libera o buffer de saída
?>