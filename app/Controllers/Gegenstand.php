<?php

namespace App\Controllers;

/*use App\Models\UserModel;*/

class Gegenstand extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function registrierteGegenstande()
    {
        $data['page_title'] = "Registrierte Gegenstände";
        $data['menuName'] = "gegenstande";
        

        return view('Gegenstand/registrierteGegenstande', $data);
    }

    public function gegenstandRegistrieren()
    {
        $data['page_title'] = "Gegenstand registrieren";
        $data['menuName'] = "add";
        $data['menuTextName'] = "gegenstand";
        

        return view('Gegenstand/gegenstandRegistrieren', $data);
    }
}
