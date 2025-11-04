<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Doces</title>
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
                max-width: 600px;
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
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            }
            form label {
                display: block;
                margin-bottom: 5px;
                font-weight: 500;
                color: #555;
            }
            form input[type="text"] {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 5px;
                font-size: 1em;
                transition: border-color 0.3s ease;
                box-sizing: border-box;
            }
            form input[type="text"]:focus {
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
                form { padding: 15px; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Cadastro de Doces</h1>
            <form action="./../controller/controller_produto.php" method="POST">
                <label>Título:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Título..." required>

                <label>Descrição:</label>
                <input type="text" id="descricao" name="descricao" placeholder="Descrição..." required>

                <label>Autor:</label>
                <input type="text" id="autor" name="autor" placeholder="Autor..." required>

                <input type="submit" id="cadastrar_produto" name="cadastrar_produto" value="Cadastrar">
            </form>
            <a href="inicial.php"><button>Voltar</button></a>
        </div>
    </body>
</html>
