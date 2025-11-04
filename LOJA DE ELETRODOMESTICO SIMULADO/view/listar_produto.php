<?php
require_once "./../controller/controller_produtos.php";

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

$doce = new Doce();
if (isset($_POST['botao_pesquisar'])) {
    $resultados = $doce->filtrar_doce($_POST['pesquisar']);
}
else {
    $resultados = $doce->listar_doces();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">       
        <title>Lista de Doces</title>
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
                max-width: 1200px;
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
            form {
                margin-bottom: 20px;
                display: flex;
                gap: 10px;
                align-items: center;
            }
            form input[type="search"] {
                flex: 1;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 1em;
            }
            form input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            form input[type="submit"]:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
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
            a {
                color: #007bff;
                text-decoration: none;
                font-weight: 500;
            }
            a:hover {
                text-decoration: underline;
            }
            .actions a {
                margin-right: 10px;
            }
            button {
                background: linear-gradient(45deg, #28a745, #20c997);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 1em;
                transition: all 0.3s ease;
                margin-top: 20px;
                margin-right: 10px;
            }
            button:hover {
                background: linear-gradient(45deg, #20c997, #17a2b8);
                transform: translateY(-2px);
            }
            .back-button {
                background: linear-gradient(45deg, #6c757d, #495057);
            }
            .back-button:hover {
                background: linear-gradient(45deg, #495057, #343a40);
            }
            @media (max-width: 768px) {
                .container { padding: 15px; }
                h1 { font-size: 2em; }
                table { font-size: 0.9em; }
                form { flex-direction: column; align-items: stretch; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Lista de Doces</h1>
            <form method="POST">
                <input type="search" id="pesquisar" name="pesquisar" placeholder="Pesquisar...">
                <input type="submit" id="botao_pesquisar" name="botao_pesquisar" value="Filtrar">
            </form>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Autor</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(count($resultados) > 0){
                            foreach($resultados as $r){
                                echo "<tr>";
                                echo "<td>".$r["DOCE_ID"]."</td>";
                                echo "<td>".$r["DOCE_TITULO"]."</td>";
                                echo "<td>".$r["DOCE_DESCRICAO"]."</td>";
                                echo "<td>".$r["DOCE_AUTOR"]."</td>";
                                echo "<td class='actions'><a href='editar_produto.php?acao=editar_doce&id=".$r["DOCE_ID"]."'>Editar</a></td>";
                                echo "<td class='actions'><a href='./../controller/controller_produto.php?acao=excluir_doce&id=".$r["DOCE_ID"]."' onclick='return confirm(\"Tem certeza que deseja excluir?\")'>Excluir</a></td>";
                                echo "</tr>";
                            }
                        }
                        else{
                            echo "<tr>";
                            echo "<td colspan='6'>Nenhum doce cadastrado!</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>

            <a href="cadastro_produto.php"><button>Cadastrar Produto</button></a>
            <a href="inicial.php"><button class="back-button">Voltar</button></a>
        </div>
    </body>
</html>