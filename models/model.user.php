<?php
@require("models/model.config.php");
class User
{
    public $idadmin;
    public $nom;
    public $postnom;
    public $email;
    public $password;
    public $titre;
    public $profile;
    public $status;
    public $id_pos;

    protected $table_name = "admin";

    public function __constructor($idadmin, $nom, $postnom, $email, $password, $titre, $profile, $status, $id_pos)
    {
        $this->idadmin = $idadmin;
        $this->nom = $nom;
        $this->postnom = $postnom;
        $this->email = $email;
        $this->password = $password;
        $this->titre = $titre;
        $this->status = $status;
        $this->profile = $profile;
        $this->id_pos = $id_pos;
    }

    function create_user_from_array($data)
    {
        $idadmin = "";
        $nom = "";
        $postnom = "";
        $email = "";
        $password = "";
        $titre = "";
        $profile = "";
        $status = "";

        for ($i = 0; $i < count($data); $i++) {
            $idadmin = $data[$i]['idAdm'];
            $nom = $data[$i]['nom'];
            $postnom = $data[$i]['postnom'];
            $email = $data[$i]['user'];
            $password = $data[$i]['pword'];
            $titre = $data[$i]['titre'];
            $profile = $data[$i]['profile'];
            $status = $data[$i]['status'];
        }

        $__ = $this;
        $__->__constructor($idadmin, $nom, $postnom, $email, $password, $titre, $profile, $status, 0);
        return $__;
    }

    public function onAuthentification($username, $password, $configs)
    {
        $query = "SELECT * FROM $this->table_name WHERE profile = '$username'";
        $line = $configs->onFetchingOne($query);
        if (is_array($line) && count($line) > 0) {
            return  $this->create_user_from_array($line);
        } else return null;
    }
}
