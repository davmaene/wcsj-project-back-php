<?php
class Stock {
    
    public $id;
    public $item;
    public $categorie;
    public $setdate;

    public function __construct($item, $categorie, $setdate, $id = null) {
        $this->id = $id;
        $this->item = $item;
        $this->categorie = $categorie;
        $this->setdate = $setdate;
    }

    public function create($config) {
        $conn = $config->db();
        if ($conn) {
            $query = "INSERT INTO __stores (item, categorie, setdate) VALUES (:item, :categorie, :setdate)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":item", $this->item);
            $stmt->bindParam(":categorie", $this->categorie);
            $stmt->bindParam(":setdate", $this->setdate);
            if ($stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}