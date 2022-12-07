<?php

namespace App\Controllers;

/*use App\Models\UserModel;*/

class Schueler extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function schuelerHinzufuegen()
    {
        $data['page_title'] = "Ausleihe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "ausleihe";
        

        return view('Schueler/schuelerHinzufuegen', $data);
    }
}
