<?php

class Facturepersonnaliseeitems
{
    public $id;
    public $ref;
    public $item;
    public $prix;
    public $qte;
    public $pack;
    protected $tablename = "facture_personaliser_items";

    public function __construct($ref, $item, $prix, $qte, $pack)
    {
        $this->ref = $ref;
        $this->item = $item;
        $this->prix = $prix;
        $this->qte = $qte;
        $this->pack = $pack;
    }

    public function create($config)
    {
        $conn = $config->db;
        if ($conn) {
            $query = "INSERT INTO $this->tablename (ref, item, prix, qte, pack) VALUES (:ref, :item, :prix, :qte, :pack)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":ref", $this->ref);
            $stmt->bindParam(":item", $this->item);
            $stmt->bindParam(":prix", $this->prix);
            $stmt->bindParam(":qte", $this->qte);
            $stmt->bindParam(":pack", $this->pack);
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
