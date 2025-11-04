<?php
    require_once __DIR__ . "/../config/db.php";

    class Usuario{
        public function buscar_usuario($email, $senha) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT * FROM USUARIO WHERE USU_EMAIL = ? AND USU_SENHA = ?");
            $select->bind_param("ss", $email, $senha);
            $select->execute();
            $resultado = $select->get_result();
            return $resultado->fetch_assoc();
        }

        public function buscar_usuario_por_id($id) {
            $conn = Database::getConnection();
            $select = $conn->prepare("SELECT * FROM USUARIO WHERE USU_ID = ?");
            $select->bind_param("i", $id);
            $select->execute();
            $resultado = $select->get_result();
            return $resultado->fetch_assoc();
        }
    }
?>
