<?php
class Produits
{
    public $id;
    public $item;
    public $categorie;
    public $qty;
    public $prix;
    public $pack;
    public $setdate;

    protected $table_name = "stocks";

    public function __construct()
    {
    }

    protected function create_user_from_array($data)
    {
        $id = 0;
        $item = "";
        $categorie = "";
        $setdate = "";

        $list = [];

        for ($i = 0; $i < count($data); $i++) {
            $k = $data[$i];
            $prd = new Produits();

            $id = $k->id;
            $item = $k->item;
            $categorie = $k->categorie;
            $setdate = $k->setdate;
            $qty = $k->qty;
            $prix = $k->prix;
            $pack = $k->pack;

            $prd->__constructor($id, $item, $categorie, $qty, $prix, $pack, $setdate);

            array_push($list, $prd);
        }

        return $list;
    }

    public function __constructor($id, $item, $categorie, $qty, $prix, $pack, $setdate)
    {
        $this->id = $id;
        $this->item = $item;
        $this->categorie = $categorie;
        $this->setdate = $setdate;
        $this->qty = $qty;
        $this->qty = $qty;
        $this->prix = $prix;
        $this->pack = $pack;
        $this->setdate = $setdate;
    }

    public function liste($id_pos, $configs)
    {
        $conn = $configs->db;
        $query = "SELECT * FROM $this->table_name JOIN stock_input ON $this->table_name.id = stock_input.item WHERE stock_input.pos = $id_pos";
        $products = array();
        $result = $conn->prepare($query);
        $result->execute();
        $products = $result->fetchAll(PDO::FETCH_CLASS, 'Produits');
        $conn = null;
        $products = $this->create_user_from_array($products);
        return $products;
    }
}
