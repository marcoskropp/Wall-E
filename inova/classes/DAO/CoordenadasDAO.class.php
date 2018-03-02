<?php

class CoordenadasDAO {

    private $conexao;

    public function __construct() {
        $this->conexao = new Conexao();
    }

    public function enviarCoordenadaAtual($coordenadas) {
        $sql = $this->conexao->getCon()->prepare("INSERT INTO coordenadaAtual(latitude,longitude) VALUES(:latitude, :longitude)");
        $sql->bindValue(":latitude", $coordenadas->getLatitude());
        $sql->bindValue(":longitude", $coordenadas->getLongitude());
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarCoordenadaAtual() {
        $sql = $this->conexao->getCon()->prepare("SELECT MAX(id) AS 'id' FROM coordenadaAtual");
        $sql->execute();
        $id = $sql->fetch();
        $sql = $this->conexao->getCon()->prepare("SELECT * FROM coordenadaAtual WHERE id = :id");
        $sql->bindValue(":id", $id['id']);
        $sql->execute();
        return $sql;
    }

    public function enviarCoordenadaFinal($coordenadas) {
        $sql = $this->conexao->getCon()->prepare("INSERT INTO coordenadaFinal(latitude,longitude) VALUES(:latitude, :longitude)");
        $sql->bindValue(":latitude", $coordenadas->getLatitude());
        $sql->bindValue(":longitude", $coordenadas->getLongitude());
        if ($sql->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscarCoordenadaFinal() {
        $sql = $this->conexao->getCon()->prepare("SELECT MAX(id) AS 'id' FROM coordenadaFinal");
        $sql->execute();
        $id = $sql->fetch();
        $sql = $this->conexao->getCon()->prepare("SELECT * FROM coordenadaFinal WHERE id = :id");
        $sql->bindValue(":id", $id['id']);
        $sql->execute();
        return $sql;
    }

}
