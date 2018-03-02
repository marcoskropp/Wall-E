<?php

class Conexao {

    private $conexao;

    public function __construct() {

        try {
            $this->conexao = new PDO("mysql:dbname=carrinho;host=127.0.0.1", "root", "toor");
            $this->conexao->exec("SET CHARACTER SET utf8");
        } catch (PDOException $e) {
            echo "FALHA: " . $e->getMessage();
        }
    }

    public function getCon() {
        return $this->conexao;
    }

}

?>