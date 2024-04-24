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
        $id_pos = 0;

        for ($i = 0; $i < count($data); $i++) {
            $idadmin = $data[$i]['idAdm'];
            $nom = $data[$i]['nom'];
            $postnom = $data[$i]['postnom'];
            $email = $data[$i]['user'];
            $password = $data[$i]['pword'];
            $titre = $data[$i]['titre'];
            $profile = $data[$i]['profile'];
            $status = $data[$i]['status'];
            $id_pos = $data[$i]['pos_id'];
        }

        $__ = $this;
        $__->__constructor($idadmin, $nom, $postnom, $email, $password, $titre, $profile, $status, $id_pos);
        return $__;
    }

    public function onAuthentification($username, $password, $configs)
    {
        $query = "SELECT admin.idAdm, admin.nom, admin.postnom, admin.user, admin.profile, admin.pword, admin.titre, admin.status, pos.id AS pos_id, pos.designation AS pos_designation, pos.details AS pos_details FROM admin LEFT JOIN pos_agents ON admin.idAdm = pos_agents.agent LEFT JOIN pos ON pos_agents.pos = pos.id WHERE admin.profile = '$password'";
        // echo($query);
        $line = $configs->onFetchingOne($query);
        if (is_array($line) && count($line) > 0) {
            return  $this->create_user_from_array($line);
        } else return null;
    }
}
