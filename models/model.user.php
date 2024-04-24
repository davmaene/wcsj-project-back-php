<?php
class User
{
    private $idadmin;
    private $nom;
    private $postnom;
    private $user;
    private $password;
    private $titre;
    private $profile;
    private $status;

    public function __construct()
    {
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
}
