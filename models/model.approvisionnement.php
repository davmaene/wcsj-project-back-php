<?php

class Appovisionnements
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
        $conn = $config->db();
        $stock = "stocks"; // step 1: Approv
        $stock_input = "stock_input"; // step 2: Approv
        $stock_input_depot = "stock_input_depot"; // step 3: Approv

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
                    $query = "INSERT INTO $stock (`id`, `item`, `categorie`, `setdate`) VALUES (:item, :categorie, :setdate)";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(":item", $this->item);
                    $stmt->bindParam(":categorie", $this->categorie);
                    $stmt->bindParam(":setdate", $this->createdon);
                    // Associez les autres paramètres avec les valeurs des propriétés correspondantes
                    // Exemple : $stmt->bindParam(":dosage", $this->dosage);
                    // Exécutez la requête
                    if ($stmt->execute()) {
                        $saved_items[] = $this;
                        // return true;
                    } else {
                        // return false;
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
            }
        } else {
            return false;
        }
    }

    // Ajoutez des méthodes pour lire, mettre à jour et supprimer des enregistrements si nécessaire
    // ...
}
