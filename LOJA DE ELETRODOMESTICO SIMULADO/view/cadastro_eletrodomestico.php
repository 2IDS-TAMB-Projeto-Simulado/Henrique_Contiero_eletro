<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

require_once __DIR__ . "/../controller/controller_eletrodomesticos.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Eletrodomésticos</title>
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
                background: #f9f9f9;
                padding: 20px;
                border-radius: 10px;
                margin-bottom: 30px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            form label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
                color: #555;
            }
            form input[type="text"], form select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 1em;
                transition: border-color 0.3s ease;
                box-sizing: border-box;
            }
            form input[type="text"]:focus, form select:focus {
                border-color: #C8E6C9;
                outline: none;
                box-shadow: 0 0 5px rgba(200, 230, 201, 0.5);
            }
            form input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-size: 1em;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(200, 230, 201, 0.3);
            }
            form input[type="submit"]:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(200, 230, 201, 0.4);
            }
            .search-form {
                margin-bottom: 20px;
                display: flex;
                gap: 10px;
                align-items: center;
            }
            .search-form input[type="text"] {
                flex: 1;
                padding: 10px;
                border: 1px solid #ddd;
                border-radius: 5px;
            }
            .search-form input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .search-form input[type="submit"]:hover {
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
            .edit-form {
                display: none;
                background: #f9f9f9;
                padding: 20px;
                border-radius: 10px;
                margin-top: 20px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            .edit-form input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .edit-form input[type="submit"]:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
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
                table { font-size: 0.9em; }
                .search-form { flex-direction: column; align-items: stretch; }
                form { padding: 15px; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Cadastro de Eletrodomésticos</h1>

            <!-- Formulário de Cadastro -->
            <form action="../controller/controller_eletrodomesticos.php" method="POST" id="form-cadastro">
                <label>Nome:</label>
                <input type="text" name="nome" placeholder="Nome do eletrodoméstico..." required>

                <label>Descrição:</label>
                <input type="text" name="descricao" placeholder="Descrição..." required>

                <label>Fornecedor:</label>
                <input type="text" name="fornecedor" placeholder="Fornecedor..." required>

                <label>Categoria:</label>
                <input type="text" name="categoria" placeholder="Categoria..." required>

                <label>Potência:</label>
                <input type="text" name="potencia" placeholder="Potência..." required>

                <label>Consumo Energético:</label>
                <input type="text" name="consumo_energetico" placeholder="Consumo energético..." required>

                <label>Garantia:</label>
                <input type="text" name="garantia" placeholder="Garantia..." required>

                <label>Prioridade de Reposição:</label>
                <select name="prioridade_reposicao" required>
                    <option value="Baixa">Baixa</option>
                    <option value="Média">Média</option>
                    <option value="Alta">Alta</option>
                </select>

                <input type="submit" name="cadastrar_eletrodomestico" value="Cadastrar">
            </form>

            <!-- Formulário de Busca -->
            <form action="" method="POST" class="search-form">
                <input type="text" name="campo" placeholder="Buscar Eletrodoméstico...">
                <input type="submit" name="filtrar_eletrodomesticos" value="Buscar">
            </form>

            <!-- Tabela de Listagem -->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Fornecedor</th>
                        <th>Categoria</th>
                        <th>Potência</th>
                        <th>Consumo Energético</th>
                        <th>Garantia</th>
                        <th>Prioridade</th>
                        <th>Estoque</th>
                        <th>Limite Mínimo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(isset($resultados) && !empty($resultados)): ?>
                        <?php foreach($resultados as $eletro): ?>
                            <tr>
                                <td><?php echo $eletro['ELETRO_ID']; ?></td>
                                <td><?php echo $eletro['ELETRO_NOME']; ?></td>
                                <td><?php echo $eletro['ELETRO_DESCRICAO']; ?></td>
                                <td><?php echo $eletro['ELETRO_FORNECEDOR']; ?></td>
                                <td><?php echo $eletro['ELETRO_CATEGORIA']; ?></td>
                                <td><?php echo $eletro['ELETRO_POTENCIA']; ?></td>
                                <td><?php echo $eletro['ELETRO_CONSUMO_ENERGETICO']; ?></td>
                                <td><?php echo $eletro['ELETRO_GARANTIA']; ?></td>
                                <td><?php echo $eletro['ELETRO_PRIORIDADE_REPOSICAO']; ?></td>
                                <td><?php echo $eletro['ESTOQUE_QUANTIDADE']; ?></td>
                                <td><?php echo $eletro['ESTOQUE_LIMITE_MINIMO']; ?></td>
                                <td class="actions">
                                    <a href="?acao=editar_eletrodomestico&id=<?php echo $eletro['ELETRO_ID']; ?>">Editar</a> |
                                    <a href="?acao=excluir_eletrodomestico&id=<?php echo $eletro['ELETRO_ID']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="12">Nenhum eletrodoméstico encontrado.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Formulário de Edição (oculto inicialmente) -->
            <?php if(isset($eletro_editar)): ?>
            <div class="edit-form">
                <h2>Editar Eletrodoméstico</h2>
                <form action="../controller/controller_eletrodomesticos.php?id=<?php echo $eletro_editar['ELETRO_ID']; ?>" method="POST">
                    <label>Nome:</label>
                    <input type="text" name="nome" value="<?php echo $eletro_editar['ELETRO_NOME']; ?>" required>

                    <label>Descrição:</label>
                    <input type="text" name="descricao" value="<?php echo $eletro_editar['ELETRO_DESCRICAO']; ?>" required>

                    <label>Fornecedor:</label>
                    <input type="text" name="fornecedor" value="<?php echo $eletro_editar['ELETRO_FORNECEDOR']; ?>" required>

                    <label>Categoria:</label>
                    <input type="text" name="categoria" value="<?php echo $eletro_editar['ELETRO_CATEGORIA']; ?>" required>

                    <label>Potência:</label>
                    <input type="text" name="potencia" value="<?php echo $eletro_editar['ELETRO_POTENCIA']; ?>" required>

                    <label>Consumo Energético:</label>
                    <input type="text" name="consumo_energetico" value="<?php echo $eletro_editar['ELETRO_CONSUMO_ENERGETICO']; ?>" required>

                    <label>Garantia:</label>
                    <input type="text" name="garantia" value="<?php echo $eletro_editar['ELETRO_GARANTIA']; ?>" required>

                    <label>Prioridade de Reposição:</label>
                    <select name="prioridade_reposicao" required>
                        <option value="Baixa" <?php if($eletro_editar['ELETRO_PRIORIDADE_REPOSICAO'] == 'Baixa') echo 'selected'; ?>>Baixa</option>
                        <option value="Média" <?php if($eletro_editar['ELETRO_PRIORIDADE_REPOSICAO'] == 'Média') echo 'selected'; ?>>Média</option>
                        <option value="Alta" <?php if($eletro_editar['ELETRO_PRIORIDADE_REPOSICAO'] == 'Alta') echo 'selected'; ?>>Alta</option>
                    </select>

                    <input type="submit" name="editar_eletrodomestico" value="Atualizar">
                    <a href="cadastro_eletrodomestico.php"><button type="button">Cancelar</button></a>
                </form>
            </div>
            <?php endif; ?>

            <a href="inicial.php"><button>Voltar</button></a>
        </div>
    </body>
</html>
