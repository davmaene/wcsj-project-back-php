<?php
class Stockinputdetails
{
    public $stock;
    public $unites;
    public $pu;
    protected $tablename = "stock_input_details";

    // Constructeur
    public function __construct($stock, $unites, $pu)
    {
        $this->stock = $stock;
        $this->unites = $unites;
        $this->pu = $pu;
    }

    public function create($config)
    {
        $conn = $config->db;
        if ($conn) {
            $query = "INSERT INTO $this->tablename (`stock`, `unites`, `pu`) VALUES (:stock, :unites, :pu)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":stock", $this->stock);
            $stmt->bindParam(":unites", $this->unites);
            $stmt->bindParam(":pu", $this->pu);
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
