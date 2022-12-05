<?php

namespace App\Controllers;

/*use App\Models\UserModel;*/

class Ausleihe extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function alleAusleihen()
    {
        $data['page_title'] = "Alle Ausleihen";
        $data['menuName'] = "ausleihen";
        

        return view('Ausleihe/alleAusleihen', $data);
    }

    public function ausleiheErstellen()
    {
        $data['page_title'] = "Ausleihe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "ausleihe";
        

        return view('Ausleihe/ausleiheErstellen', $data);
    }
}
