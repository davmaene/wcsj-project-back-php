<?php

class User
{
    private $nom;
    private $postnom;
    private $phone;
    private $email; // ceci represente le nom_d_utilisateur
    private $password;
    private $niveau_acces;

    public function __construct()
    {
    }
    public function __constructor($nom, $postnom, $phone, $email, $password, $niveau_acces)
    {
        $this->nom = $nom;
        $this->postnom = $postnom;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->niveau_acces = $niveau_acces;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function getPostnom()
    {
        return $this->postnom;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getNiveauAcces()
    {
        return $this->niveau_acces;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function setPostnom($postnom)
    {
        $this->postnom = $postnom;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setNiveauAcces($niveau_acces)
    {
        $this->niveau_acces = $niveau_acces;
    }
}
