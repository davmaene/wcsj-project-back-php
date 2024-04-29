<?php
class Stockinput {

    public $id;
    public $item;
    public $date_exp;
    public $ref;
    public $qty;
    public $prix;
    public $date;
    public $setter;
    public $pos;
    public $pack;

    public function __construct($item, $date_exp, $ref, $qty, $prix, $date, $setter, $pos, $pack, $id = null) {
        $this->id = $id;
        $this->item = $item;
        $this->date_exp = $date_exp;
        $this->ref = $ref;
        $this->qty = $qty;
        $this->prix = $prix;
        $this->date = $date;
        $this->setter = $setter;
        $this->pos = $pos;
        $this->pack = $pack;
    }

    public function create($config) {
        $conn = $config->db();
        if ($conn) {
            $query = "INSERT INTO __stores (item, date_exp, ref, qty, prix, date, setter, pos, pack) VALUES (:item, :date_exp, :ref, :qty, :prix, :date, :setter, :pos, :pack)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":item", $this->item);
            $stmt->bindParam(":date_exp", $this->date_exp);
            $stmt->bindParam(":ref", $this->ref);
            $stmt->bindParam(":qty", $this->qty);
            $stmt->bindParam(":prix", $this->prix);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":setter", $this->setter);
            $stmt->bindParam(":pos", $this->pos);
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