<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Login - Loja de Eletrodomésticos</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap');
            body {
                font-family: 'Roboto', sans-serif;
                margin: 0;
                padding: 0;
                background: linear-gradient(135deg, #E3F2FD 0%, #BBDEFB 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .container {
                background: rgba(255, 255, 255, 0.95);
                padding: 40px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
                max-width: 400px;
                width: 90%;
                text-align: center;
            }
            h1 {
                color: #333;
                margin-bottom: 20px;
                font-size: 2em;
                font-weight: 700;
            }
            form {
                display: flex;
                flex-direction: column;
            }
            label {
                display: block;
                margin-bottom: 8px;
                font-weight: 500;
                color: #555;
            }
            input[type="email"], input[type="password"] {
                width: 100%;
                padding: 12px;
                margin-bottom: 15px;
                border: 1px solid #ddd;
                border-radius: 8px;
                font-size: 1em;
                transition: border-color 0.3s ease;
                box-sizing: border-box;
            }
            input[type="email"]:focus, input[type="password"]:focus {
                border-color: #C8E6C9;
                outline: none;
                box-shadow: 0 0 5px rgba(200, 230, 201, 0.5);
            }
            input[type="submit"] {
                background: linear-gradient(45deg, #C8E6C9, #A5D6A7);
                color: white;
                padding: 12px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 1em;
                font-weight: 500;
                transition: all 0.3s ease;
                box-shadow: 0 4px 15px rgba(200, 230, 201, 0.3);
            }
            input[type="submit"]:hover {
                background: linear-gradient(45deg, #A5D6A7, #C8E6C9);
                transform: translateY(-2px);
                box-shadow: 0 6px 20px rgba(200, 230, 201, 0.4);
            }
            .erro {
                color: #e74c3c;
                font-weight: 500;
                margin-bottom: 15px;
                background: #ffeaea;
                padding: 10px;
                border-radius: 5px;
                border-left: 4px solid #e74c3c;
            }
            @media (max-width: 768px) {
                .container { padding: 20px; }
                h1 { font-size: 1.8em; }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Login - Loja de Eletrodomésticos</h1>
            <form action="../controller/controller_usuario.php" method="POST">
                <label>Email:</label>
                <input type="email" id="email" name="email" placeholder="Email..." required>

                <label>Senha:</label>
                <input type="password" id="senha" name="senha" placeholder="Senha..." required>

                <?php
                    session_start();
                    if(isset($_SESSION['erro_login'])){
                        echo "<div class='erro'>" . $_SESSION['erro_login'] . "</div>";
                        unset($_SESSION['erro_login']);
                    }
                ?>

                <input type="submit" id="login" name="login" value="Acessar">
            </form>
        </div>
    </body>
</html>
