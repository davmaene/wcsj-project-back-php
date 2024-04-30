<?php
class Facturepersonnalisee
{
    public $id;
    public $user;
    public $pos;
    public $client;
    public $date;
    protected $tablename = "facture_personaliser";

    public function __construct($id, $user, $pos, $client, $date)
    {
        $this->id = $id;
        $this->user = $user;
        $this->pos = $pos;
        $this->client = $client;
        $this->date = $date;
    }

    public function create($config)
    {
        $conn = $config->db;
        if ($conn) {
            $query = "INSERT INTO $this->tablename (user, pos, client, date) VALUES (:user, :pos, :client, :date)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":user", $this->user);
            $stmt->bindParam(":pos", $this->pos);
            $stmt->bindParam(":client", $this->client);
            $stmt->bindParam(":date", $this->date);
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
