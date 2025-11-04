<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/../controller/controller_estoque.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Gestão de Estoque</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
            body {
                font-family: 'Roboto', sans-serif;
                margin: 0;
                padding: 20px;
                background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
                min-height: 100vh;
                color: #333;
            }
            .container {
                max-width: 1400px;
                margin: 0 auto;
                background: rgba(255, 255, 255, 0.95);
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            }
            h1 {
                text-align: center;
                color: #333;
                margin-bottom: 30px;
                font-size: 2.5em;
                font-weight: 700;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background: white;
                border-radius: 10px;
                overflow: hidden;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            th, td {
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #eee;
            }
            th {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                font-weight: 500;
            }
            tr:nth-child(even) {
                background: #f9f9f9;
            }
            tr:hover {
                background: #e9ecef;
                transition: background 0.3s ease;
            }
            .alerta {
                color: #e74c3c;
                font-weight: 700;
            }
            input[type="number"], select, input[type="datetime-local"] {
                width: 100%;
                padding: 8px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 0.9em;
                transition: border-color 0.3s ease;
                box-sizing: border-box;
            }
            input[type="number"]:focus, select:focus, input[type="datetime-local"]:focus {
                border-color: #C8E6C9;
                outline: none;
                box-shadow: 0 0 5px rgba(200, 230, 201, 0.5);
            }
            input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 8px 15px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 0.9em;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 2px 10px rgba(200, 230, 201, 0.3);
            }
            input[type="submit"]:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(200, 230, 201, 0.4);
            }
            button {
                background: linear-gradient(45deg, #6c757d, #495057);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 1em;
                transition: all 0.3s ease;
                margin-top: 20px;
            }
            button:hover {
                background: linear-gradient(45deg, #495057, #343a40);
                transform: translateY(-2px);
            }
            @media (max-width: 768px) {
                .container { padding: 15px; }
                h1 { font-size: 2em; }
                table { font-size: 0.8em; }
                th, td { padding: 8px; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Gestão de Estoque</h1>

            <table>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Fornecedor</th>
                <th>Categoria</th>
                <th>Quantidade no Estoque</th>
                <th>Limite Mínimo</th>
                <th>Status</th>
                <th>Ação</th>
                <th>Quantidade</th>
                <th>Data da Movimentação</th>
                <th>Movimentar Estoque</th>
            </tr>
            <?php
                if(count($eletrodomesticos) > 0){
                    foreach($eletrodomesticos as $e){
                        $status = ($e["ESTOQUE_QUANTIDADE"] <= $e["ESTOQUE_LIMITE_MINIMO"]) ? "<span class='alerta'>Abaixo do mínimo</span>" : "OK";
                        echo "<form method='POST' action='../controller/controller_estoque.php'>";
                        echo "<tr>";
                        echo "<td><input type='number' name='eletro_id' value='".$e["ELETRO_ID"]."' readonly></td>";
                        echo "<td>".$e["ELETRO_NOME"]."</td>";
                        echo "<td>".$e["ELETRO_DESCRICAO"]."</td>";
                        echo "<td>".$e["ELETRO_FORNECEDOR"]."</td>";
                        echo "<td>".$e["ELETRO_CATEGORIA"]."</td>";
                        echo "<td>".$e["ESTOQUE_QUANTIDADE"]."</td>";
                        echo "<td>".$e["ESTOQUE_LIMITE_MINIMO"]."</td>";
                        echo "<td>".$status."</td>";
                        echo "<td>
                                    <select id='acao_estoque' name='acao_estoque' required>
                                        <option value=''>Selecione...</option>
                                        <option value='entrada'>Entrada no Estoque</option>
                                        <option value='saida'>Saída do Estoque</option>
                                    </select>
                                </td>";
                        echo "<td><input type='number' id='qtd_movimentacao' name='qtd_movimentacao' min='1' required></td>";
                        echo "<td><input type='datetime-local' id='data_movimentacao' name='data_movimentacao' required></td>";
                        echo "<td><input type='submit' id='botao_movimentar' name='botao_movimentar' value='Movimentar'></td>";
                        echo "</tr>";
                        echo "</form>";
                    }
                }
                else{
                    echo "<tr>";
                    echo "<td colspan='12'>Nenhum eletrodoméstico cadastrado!</td>";
                    echo "</tr>";
                }
            ?>
            </table>

            <a href="inicial.php"><button>Voltar</button></a>
        </div>
    </body>
</html>
