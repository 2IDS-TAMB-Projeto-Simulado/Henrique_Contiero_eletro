<?php
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/model_estoque.php";
    require_once __DIR__ . "/model_logs.php";

    class Doce{
        public function cadastrar_doce($titulo, $descricao, $autor, $fk_usu_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("INSERT INTO DOCE (DOCE_TITULO, DOCE_DESCRICAO, DOCE_AUTOR, FK_USU_ID) VALUES (?, ?, ?, ?)");
            $insert->bind_param("sssi", $titulo, $descricao, $autor, $fk_usu_id);
            $success = $insert->execute();

            if($success){
                $doce_id = $conn->insert_id;

                $estoque = new Estoque();
                $estoque->adicionar_estoque(0,$fk_usu_id,$doce_id);

                $logs = new Logs();
                $logs->cadastrar_logs("DOCE <br> ID: ".$doce_id." <br> TITULO: ".$titulo." <br> AÇÃO: Cadastrado! <br> ID USUÁRIO: ".$fk_usu_id);
            }

            $insert->close();
            return $success;
        }

        public function listar_doces() {
            $conn = Database::getConnection();
            $sql = "SELECT      D.DOCE_ID,
                                D.DOCE_TITULO,
                                D.DOCE_DESCRICAO,
                                D.DOCE_AUTOR,
                                E.ESTOQUE_QUANTIDADE,
                                U.USU_NOME,
                                U.USU_EMAIL
                    FROM        DOCE D
                    JOIN        USUARIO U ON D.FK_USU_ID = U.USU_ID
                    JOIN        ESTOQUE E ON D.DOCE_ID = E.FK_DOCE_ID
                    ORDER BY    D.DOCE_TITULO";
            $result = $conn->query($sql);
            return $result->fetch_all(MYSQLI_ASSOC);
        }

        public function excluir_doce($doce_id, $fk_usu_id) {
            $conn = Database::getConnection();

            // First delete from ESTOQUE
            $delete_estoque = $conn->prepare("DELETE FROM ESTOQUE WHERE FK_DOCE_ID = ?");
            $delete_estoque->bind_param("i", $doce_id);
            $estoque_success = $delete_estoque->execute();
            $delete_estoque->close();

            if($estoque_success){
                // Then delete from DOCE
                $delete = $conn->prepare("DELETE FROM DOCE WHERE DOCE_ID = ?");
                $delete->bind_param("i", $doce_id);
                $success = $delete->execute();
                $delete->close();

                if($success){
                    $logs = new Logs();
                    $logs->cadastrar_logs("DOCE <br> ID: ".$doce_id." <br> AÇÃO: Excluído! <br> ID USUÁRIO: ".$fk_usu_id);
                }

                return $success;
            } else {
                return false;
            }
        }

        public function buscar_doce_pelo_id($id) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        D.DOCE_ID,
                                                    D.DOCE_TITULO,
                                                    D.DOCE_DESCRICAO,
                                                    D.DOCE_AUTOR,
                                                    E.ESTOQUE_QUANTIDADE,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        DOCE D
                                        JOIN        USUARIO U ON D.FK_USU_ID = U.USU_ID
                                        JOIN        ESTOQUE E ON D.DOCE_ID = E.FK_DOCE_ID
                                        WHERE       D.DOCE_ID = ?
                                        ORDER BY    D.DOCE_TITULO");
            $select->bind_param("i", $id);
            $select->execute();
            $result = $select->get_result();
            $doce = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $doce;
        }

        public function editar_doce($titulo, $descricao, $autor, $doce_id, $fk_usu_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("UPDATE DOCE SET DOCE_TITULO = ?, DOCE_DESCRICAO = ?, DOCE_AUTOR = ? WHERE DOCE_ID = ?");
            $insert->bind_param("sssi", $titulo, $descricao, $autor, $doce_id);
            $success = $insert->execute();

            if($success){
                $logs = new Logs();
                $logs->cadastrar_logs("DOCE <br> ID: ".$doce_id." <br> TITULO: ".$titulo." <br> AÇÃO: Editado! <br> ID USUÁRIO: ".$fk_usu_id);
            }

            $insert->close();
            return $success;
        }

        public function filtrar_doce($campo) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT        D.DOCE_ID,
                                                    D.DOCE_TITULO,
                                                    D.DOCE_DESCRICAO,
                                                    D.DOCE_AUTOR,
                                                    E.ESTOQUE_QUANTIDADE,
                                                    U.USU_NOME,
                                                    U.USU_EMAIL
                                        FROM        DOCE D
                                        JOIN        USUARIO U ON D.FK_USU_ID = U.USU_ID
                                        JOIN        ESTOQUE E ON D.DOCE_ID = E.FK_DOCE_ID
                                        WHERE       D.DOCE_TITULO LIKE ?
                                        ORDER BY    D.DOCE_TITULO");
            $termo = "%" . $campo . "%";
            $select->bind_param("s", $termo);
            $select->execute();
            $result = $select->get_result();
            $doces = $result->fetch_all(MYSQLI_ASSOC);
            $select->close();
            return $doces;
        }
    }
?>