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
        <title>Página Inicial - Loja de Eletrodomésticos</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
            body {
                font-family: 'Roboto', sans-serif;
                margin: 0;
                padding: 0;
                background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                color: #333;
            }
            .container {
                background: rgba(255, 255, 255, 0.95);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                text-align: center;
                max-width: 600px;
                width: 90%;
            }
            h1, h2, h3 {
                margin: 10px 0;
                color: #333;
            }
            h1 { font-size: 2.5em; font-weight: 700; }
            h2 { font-size: 1.8em; font-weight: 500; }
            h3 { font-size: 1.4em; font-weight: 400; margin-bottom: 30px; }
            .buttons {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
                gap: 15px;
            }
            button {
                padding: 12px 25px;
                margin: 0;
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                border: none;
                border-radius: 25px;
                cursor: pointer;
                font-size: 1em;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(200, 230, 201, 0.3);
            }
            button:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(200, 230, 201, 0.4);
            }
            @media (max-width: 768px) {
                .container { padding: 20px; }
                h1 { font-size: 2em; }
                .buttons { flex-direction: column; align-items: center; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Página Inicial</h1>
            <h2>Loja de Eletrodomésticos</h2>
            <h3>Bem vindo, <?php echo $_SESSION['usuario']['USU_NOME']; ?>!</h3>
            <div class="buttons">
                <a href="cadastro_eletrodomestico.php"><button>Cadastro de Eletrodomésticos</button></a>
                <a href="gestao_estoque.php"><button>Gestão de Estoque</button></a>
                <a href="../controller/controller_usuario.php?acao=logout"><button>Logout</button></a>
            </div>
        </div>
    </body>
</html>
