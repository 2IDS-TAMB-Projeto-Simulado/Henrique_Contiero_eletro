<?php
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/model_estoque.php";
    require_once __DIR__ . "/model_logs.php";

    class Eletrodomestico{
        public function cadastrar_eletrodomestico($nome, $descricao, $fornecedor, $categoria, $potencia, $consumo_energetico, $garantia, $prioridade_reposicao, $fk_usu_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("INSERT INTO ELETRODOMESTICO (ELETRO_NOME, ELETRO_DESCRICAO, ELETRO_FORNECEDOR, ELETRO_CATEGORIA, ELETRO_POTENCIA, ELETRO_CONSUMO_ENERGETICO, ELETRO_GARANTIA, ELETRO_PRIORIDADE_REPOSICAO, FK_USU_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("ssssssssi", $nome, $descricao, $fornecedor, $categoria, $potencia, $consumo_energetico, $garantia, $prioridade_reposicao, $fk_usu_id);
            $success = $insert->execute();

            if($success){
                $eletro_id = $conn->insert_id;

                $estoque = new Estoque();
                $estoque->adicionar_estoque(0, 0, $fk_usu_id, $eletro_id); // quantidade inicial 0, limite mínimo 0

                $logs = new Logs();
                $logs->cadastrar_logs("ELETRODOMESTICO <br> ID: ".$eletro_id." <br> NOME: ".$nome." <br> AÇÃO: Cadastrado! <br> ID USUÁRIO: ".$fk_usu_id, 'ENTRADA', $fk_usu_id);
            }

            $insert->close();
            return $success;
        }

        public function listar_eletrodomesticos() {
            $conn = Database::getConnection();
            $sql = "SELECT      E.ELETRO_ID,
                                E.ELETRO_NOME,
                                E.ELETRO_DESCRICAO,
                                E.ELETRO_FORNECEDOR,
                                E.ELETRO_CATEGORIA,
                                E.ELETRO_POTENCIA,
                                E.ELETRO_CONSUMO_ENERGETICO,
                                E.ELETRO_GARANTIA,
                                E.ELETRO_PRIORIDADE_REPOSICAO,
                                EST.ESTOQUE_QUANTIDADE,
                                EST.ESTOQUE_LIMITE_MINIMO,
                                U.USU_NOME,
                                U.USU_EMAIL
                    FROM        ELETRODOMESTICO E
                    JOIN        USUARIO U ON E.FK_USU_ID = U.USU_ID
                    JOIN        ESTOQUE EST ON E.ELETRO_ID = EST.FK_ELETRO_ID
                    ORDER BY    E.ELETRO_NOME";
            $result = $conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function excluir_eletrodomestico($eletro_id, $fk_usu_id) {
            $conn = Database::getConnection();

            // First delete from ESTOQUE
            $delete_estoque = $conn->prepare("DELETE FROM ESTOQUE WHERE FK_ELETRO_ID = ?");
            $delete_estoque->bind_param("i", $eletro_id);
            $estoque_success = $delete_estoque->execute();
            $delete_estoque->close();

            if($estoque_success){
                // Then delete from ELETRODOMESTICO
                $delete = $conn->prepare("DELETE FROM ELETRODOMESTICO WHERE ELETRO_ID = ?");
                $delete->bind_param("i", $eletro_id);
                $success = $delete->execute();
                $delete->close();

                if($success){
                    $logs = new Logs();
                    $logs->cadastrar_logs("ELETRODOMESTICO <br> ID: ".$eletro_id." <br> AÇÃO: Excluído! <br> ID USUÁRIO: ".$fk_usu_id, 'EXCLUSAO', $fk_usu_id);
                }

                return $success;
            } else {
                return false;
            }
        }

        public function buscar_eletrodomestico_pelo_id($id) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        E.ELETRO_ID,
                                                    E.ELETRO_NOME,
                                                    E.ELETRO_DESCRICAO,
                                                    E.ELETRO_FORNECEDOR,
                                                    E.ELETRO_CATEGORIA,
                                                    E.ELETRO_POTENCIA,
                                                    E.ELETRO_CONSUMO_ENERGETICO,
                                                    E.ELETRO_GARANTIA,
                                                    E.ELETRO_PRIORIDADE_REPOSICAO,
                                                    EST.ESTOQUE_QUANTIDADE,
                                                    EST.ESTOQUE_LIMITE_MINIMO,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        ELETRODOMESTICO E
                                        JOIN        USUARIO U ON E.FK_USU_ID = U.USU_ID
                                        JOIN        ESTOQUE EST ON E.ELETRO_ID = EST.FK_ELETRO_ID
                                        WHERE       E.ELETRO_ID = ?
                                        ORDER BY    E.ELETRO_NOME");
            $select->bind_param("i", $id);
            $select->execute();
            $result = $select->get_result();
            $eletro = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $eletro;
        }

        public function editar_eletrodomestico($nome, $descricao, $fornecedor, $categoria, $potencia, $consumo_energetico, $garantia, $prioridade_reposicao, $eletro_id, $fk_usu_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("UPDATE ELETRODOMESTICO SET ELETRO_NOME = ?, ELETRO_DESCRICAO = ?, ELETRO_FORNECEDOR = ?, ELETRO_CATEGORIA = ?, ELETRO_POTENCIA = ?, ELETRO_CONSUMO_ENERGETICO = ?, ELETRO_GARANTIA = ?, ELETRO_PRIORIDADE_REPOSICAO = ? WHERE ELETRO_ID = ?");
            $insert->bind_param("ssssssssi", $nome, $descricao, $fornecedor, $categoria, $potencia, $consumo_energetico, $garantia, $prioridade_reposicao, $eletro_id);
            $success = $insert->execute();

            if($success){
                $logs = new Logs();
                $logs->cadastrar_logs("ELETRODOMESTICO <br> ID: ".$eletro_id." <br> NOME: ".$nome." <br> AÇÃO: Editado! <br> ID USUÁRIO: ".$fk_usu_id, 'EDICAO', $fk_usu_id);
            }

            $insert->close();
            return $success;
        }

        public function filtrar_eletrodomestico($campo) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        E.ELETRO_ID,
                                                    E.ELETRO_NOME,
                                                    E.ELETRO_DESCRICAO,
                                                    E.ELETRO_FORNECEDOR,
                                                    E.ELETRO_CATEGORIA,
                                                    E.ELETRO_POTENCIA,
                                                    E.ELETRO_CONSUMO_ENERGETICO,
                                                    E.ELETRO_GARANTIA,
                                                    E.ELETRO_PRIORIDADE_REPOSICAO,
                                                    EST.ESTOQUE_QUANTIDADE,
                                                    EST.ESTOQUE_LIMITE_MINIMO,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        ELETRODOMESTICO E
                                        JOIN        USUARIO U ON E.FK_USU_ID = U.USU_ID
                                        JOIN        ESTOQUE EST ON E.ELETRO_ID = EST.FK_ELETRO_ID
                                        WHERE       E.ELETRO_NOME LIKE ?
                                        ORDER BY    E.ELETRO_NOME");
            $termo = "%" . $campo . "%";
            $select->bind_param("s", $termo);
            $select->execute();
            $result = $select->get_result();
            $eletros = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $eletros;
        }
    }
?>
