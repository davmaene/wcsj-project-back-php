<?php

class Approvisionnements
{

    public $id;
    public $item;
    public $prix;
    public $date_expiration;
    public $dosage;
    public $marque;
    public $qte_pack;
    public $num_lot;
    public $categorie;
    public $qte_unit;
    public $paquetage;
    public $nature;
    public $pays_origin;
    public $prix_unit;
    public $issynch;
    public $createdon;

    public function __construct()
    {
    }

    public function __constructor($item, $prix, $date_expiration, $dosage, $marque, $qte_pack, $num_lot, $categorie, $qte_unit, $paquetage, $nature, $pays_origin, $prix_unit, $issynch, $createdon)
    {
        $this->item = $item;
        $this->prix = $prix;
        $this->date_expiration = $date_expiration;
        $this->dosage = $dosage;
        $this->marque = $marque;
        $this->qte_pack = $qte_pack;
        $this->num_lot = $num_lot;
        $this->categorie = $categorie;
        $this->qte_unit = $qte_unit;
        $this->paquetage = $paquetage;
        $this->nature = $nature;
        $this->pays_origin = $pays_origin;
        $this->prix_unit = $prix_unit;
        $this->issynch = $issynch;
        $this->createdon = $createdon;
    }

    public function create($config, $setter, $pos, $items = [])
    {
        $saved_items = [];
        $conn = $config->db;

        if ($conn) {
            try {
                foreach ($items as $key => $value) {
                    $this->__constructor(
                        $value['item'],
                        $value['prix'],
                        $value['date_expiration'],
                        $value['dosage'],
                        $value['marque'],
                        $value['qte_pack'],
                        $value['num_lot'],
                        $value['categorie'],
                        $value['qte_unit'],
                        $value['paquetage'],
                        $value['nature'],
                        $value['pays_origin'],
                        $value['prix_unit'],
                        $value['issynch'],
                        $value['createdon']
                    );

                    $stock_raw = new Stock($this->item, $this->categorie, null);
                    $stock_raw = $stock_raw->create($config);

                    if ($stock_raw) {
                        $stock_input_raw = new Stockinput($stock_raw, $this->date_expiration, 0, $this->qte_unit, $this->prix_unit, $this->createdon, $setter, $pos, $this->paquetage, null);
                        $stock_input_raw = $stock_input_raw->create($config);
                        if ($stock_input_raw) {
                            
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }
                return $saved_items;
            } catch (\Throwable $th) {
                return false;
            }
        } else {
            return false;
        }
    }
}
