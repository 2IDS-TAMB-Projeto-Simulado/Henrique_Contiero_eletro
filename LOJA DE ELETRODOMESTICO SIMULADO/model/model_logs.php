<?php
require_once __DIR__ . "/../config/db.php";

class Logs {
    // Aceita até 3 parâmetros, mas usa só o primeiro (descrição)
    public function cadastrar_logs($descricao, $param2 = null, $param3 = null) {
        $conn = Database::getConnection();

        // Sempre insere com a data e hora atuais
        $insert = $conn->prepare("INSERT INTO LOGS (LOG_DESCRICAO, LOG_DATA_HORA) VALUES (?, NOW())");
        $insert->bind_param("s", $descricao);
        
        $success = $insert->execute();
        $insert->close();
        return $success;
    }

    public function listar_logs() {
        $conn = Database::getConnection();
        $sql = "SELECT LOG_ID, LOG_DESCRICAO, LOG_DATA_HORA 
                FROM LOGS 
                ORDER BY LOG_DATA_HORA DESC";
        $result = $conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>