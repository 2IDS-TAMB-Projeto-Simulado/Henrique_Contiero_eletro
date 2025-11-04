<?php
    require_once "../model/model_doce.php";
    session_start();

    //CADASTRAR DOCE
    if(isset($_POST["cadastrar_doce"])){
        $doce = new Doce();
        $resultado = $doce->cadastrar_doce($_POST["titulo"], $_POST["descricao"], $_POST["autor"], $_SESSION['usuario']["USU_ID"]);
        if($resultado){
            echo "<script>
                    alert('Doce cadastrado com sucesso!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        else {
            echo "<script>
                    alert('Erro ao cadastrar doce!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        exit();
    }

    //BUSCAR DADOS PARA EDITAR DOCE
    else if(isset($_GET["acao"]) && $_GET["acao"] == "editar_doce"){
        $doce = new Doce();
        $resultados = $doce->buscar_doce_pelo_id($_GET["id"]);

        if(!empty($resultados)) {
            $doce_editar = $resultados[0];
        } else {
            echo "<script>
                    alert('Doce não encontrado!');
                    window.location.href='listar_doces.php';
                </script>";
            exit();
        }
    }

    //EDITAR DOCE
    if(isset($_POST["editar_doce"])){
        $doce = new Doce();
        $resultado = $doce->editar_doce($_POST["titulo"], $_POST["descricao"], $_POST["autor"], $_GET["id"], $_SESSION['usuario']["USU_ID"]);
        if($resultado){
            echo "<script>
                    alert('Doce atualizado com sucesso!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        else {
            echo "<script>
                    alert('Erro ao atualizar doce!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        exit();
    }

    //EXCLUIR DOCE
    else if(isset($_GET["acao"]) && $_GET["acao"] == "excluir_doce"){
        $doce = new Doce();
        $resultado = $doce->excluir_doce($_GET["id"], $_SESSION['usuario']['USU_ID']);
        if($resultado){
            echo "<script>
                    alert('Doce excluído com sucesso!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        else {
            echo "<script>
                    alert('Erro ao excluir doce!');
                    window.location.href='../view/listar_doces.php';
                </script>";
        }
        exit();
    }
?>
