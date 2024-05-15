<?php
class Stockdetails
{
    public $stock;
    public $marque;
    public $pays_originire;
    public $dosage;
    public $paquettage;
    public $nature;
    public $autres;
    protected $tablename = "stock_details";

    // Constructeur
    public function __construct($stock, $marque, $pays_originire, $dosage, $paquettage, $nature, $autres)
    {
        $this->stock = $stock;
        $this->marque = $marque;
        $this->pays_originire = $pays_originire;
        $this->dosage = $dosage;
        $this->paquettage = $paquettage;
        $this->nature = $nature;
        $this->autres = $autres;
    }

    public function create($config)
    {
        $conn = $config->db;
        if ($conn) {
            $query = "INSERT INTO $this->tablename (stock, marque, pays_originire, dosage, paquetage, nature, autres) VALUES (:stock, :marque, :pays_originire, :dosage, :paquettage, :nature, :autres)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":stock", $this->stock);
            $stmt->bindParam(":marque", $this->marque);
            $stmt->bindParam(":pays_originire", $this->pays_originire);
            $stmt->bindParam(":dosage", $this->dosage);
            $stmt->bindParam(":paquettage", $this->paquettage);
            $stmt->bindParam(":nature", $this->nature);
            $stmt->bindParam(":autres", $this->autres);
            if ($stmt->execute()) {
                return $conn->lastInsertId();
            } else {
                return "0 not executed";
            }
        } else {
            return "0 diff conne";
        }
    }
}
