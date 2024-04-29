<?php
class Stockinputdepot {

    public $id;
    public $item;
    public $date_exp;
    public $ref;
    public $qty;
    public $prix;
    public $date;
    public $setter;
    protected $tablename = "stock_input_depot";

    public function __construct($item, $date_exp, $ref, $qty, $prix, $date, $setter, $id = null) {
        $this->id = $id;
        $this->item = $item;
        $this->date_exp = $date_exp;
        $this->ref = $ref;
        $this->qty = $qty;
        $this->prix = $prix;
        $this->date = $date;
        $this->setter = $setter;
    }

    public function create($config) {
        $conn = $config->db();
        if ($conn) {
            $query = "INSERT INTO __stores (item, date_exp, ref, qty, prix, date, setter) VALUES (:item, :date_exp, :ref, :qty, :prix, :date, :setter)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":item", $this->item);
            $stmt->bindParam(":date_exp", $this->date_exp);
            $stmt->bindParam(":ref", $this->ref);
            $stmt->bindParam(":qty", $this->qty);
            $stmt->bindParam(":prix", $this->prix);
            $stmt->bindParam(":date", $this->date);
            $stmt->bindParam(":setter", $this->setter);
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