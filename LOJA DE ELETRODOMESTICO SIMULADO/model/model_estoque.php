<?php
    require_once __DIR__ . "/../config/db.php";
    require_once __DIR__ . "/model_logs.php";

    class Estoque{
        public function adicionar_estoque($quantidade, $limite_minimo, $fk_usu_id, $fk_eletro_id) {
            $conn = Database::getConnection();
            $insert = $conn->prepare("INSERT INTO ESTOQUE (ESTOQUE_QUANTIDADE, ESTOQUE_LIMITE_MINIMO, FK_ELETRO_ID) VALUES (?, ?, ?)");
            $insert->bind_param("iii", $quantidade, $limite_minimo, $fk_eletro_id);
            $success = $insert->execute();
            $insert->close();
            return $success;
        }

        public function atualizar_estoque($quantidade, $fk_eletro_id, $fk_usu_id, $tipo_movimentacao, $data_movimentacao) {
            $conn = Database::getConnection();
            $update = $conn->prepare("UPDATE ESTOQUE SET ESTOQUE_QUANTIDADE = ? WHERE FK_ELETRO_ID = ?");
            $update->bind_param("ii", $quantidade, $fk_eletro_id);
            $success = $update->execute();

            if($success){
                $logs = new Logs();
                $logs->cadastrar_logs("Eletrodoméstico <br> ID: ".$fk_eletro_id." <br> AÇÃO: Estoque editado <br> NOVA QTD: ".$quantidade."<br> ID USUÁRIO: ".$fk_usu_id, $tipo_movimentacao, $fk_usu_id, $data_movimentacao);
            }
            $update->close();
            return $success;
        }

        public function verificar_alerta($fk_eletro_id) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT ESTOQUE_QUANTIDADE, ESTOQUE_LIMITE_MINIMO FROM ESTOQUE WHERE FK_ELETRO_ID = ?");
            $select->bind_param("i", $fk_eletro_id);
            $select->execute();
            $result = $select->get_result();
            $estoque = $result->fetch_assoc();
            $select->close();

            if ($estoque && $estoque['ESTOQUE_QUANTIDADE'] <= $estoque['ESTOQUE_LIMITE_MINIMO']) {
                return true; // Alerta: estoque abaixo do mínimo
            }
            return false;
        }

        public function movimentar_estoque($fk_eletro_id, $quantidade_movimentacao, $tipo, $fk_usu_id, $data_movimentacao) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT ESTOQUE_QUANTIDADE FROM ESTOQUE WHERE FK_ELETRO_ID = ?");
            $select->bind_param("i", $fk_eletro_id);
            $select->execute();
            $result = $select->get_result();
            $estoque_atual = $result->fetch_assoc()['ESTOQUE_QUANTIDADE'];
            $select->close();

            if ($tipo == 'ENTRADA') {
                $nova_quantidade = $estoque_atual + $quantidade_movimentacao;
            } elseif ($tipo == 'SAIDA') {
                $nova_quantidade = $estoque_atual - $quantidade_movimentacao;
                if ($nova_quantidade < 0) {
                    return false; // Não permitir saída se estoque insuficiente
                }
            } else {
                return false; // Tipo inválido
            }

            return $this->atualizar_estoque($nova_quantidade, $fk_eletro_id, $fk_usu_id, $tipo, $data_movimentacao);
        }
    }
?>
