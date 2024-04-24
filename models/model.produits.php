<?php
class Produits
{
    public $id;
    public $item;
    public $categorie;
    public $setdate;

    public function __construct()
    {
    }

    public function __constructor($id, $item, $categorie, $setdate)
    {
        $this->id = $id;
        $this->item = $item;
        $this->categorie = $categorie;
        $this->setdate = $setdate;
    }
}
