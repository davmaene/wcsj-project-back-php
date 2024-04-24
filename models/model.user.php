<?php
@require("models/model.config.php");
class User extends WCSJ
{
    private $idadmin;
    private $nom;
    private $postnom;
    private $user;
    private $password;
    private $titre;
    private $profile;
    private $status;

    protected $table_name = "admin";

    public function __construct()
    {
        $this->onConnexionToDB();
    }

    public function __constructor($idadmin, $nom, $postnom, $user, $password, $titre, $profile, $status)
    {
        $this->idadmin = $idadmin;
        $this->nom = $nom;
        $this->postnom = $postnom;
        $this->user = $user;
        $this->password = $password;
        $this->titre = $titre;
        $this->status = $status;
        $this->profile = $profile;
    }

    public function onAuthentification($username, $password)
    {
        $query = "SELECT * FROM $this->table_name WHERE profile = $password";
        $line = $this->onFetchingOne($query);
        return $line;
    }
}
