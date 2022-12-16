<?php

namespace App\Controllers;

use App\Models\SchuelerModel;

use App\Libraries\SchuelerHelper;

class Schueler extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();
        helper(['url', 'form']);
    }

    public function schuelerHinzufuegen($schuelerId = false)
    {
        if($schuelerId == false)
        {
            return view('errors/html/error_404');
        }
        
        $data['page_title'] = "Ausleihe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "ausleihe";
        
        $data['schuelerId'] = $schuelerId;

        return view('Schueler/schuelerHinzufuegen', $data);
    }
}
