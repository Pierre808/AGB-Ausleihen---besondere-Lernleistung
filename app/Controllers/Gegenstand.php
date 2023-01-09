<?php

namespace App\Controllers;

use App\Libraries\GegenstandHelper;

class Gegenstand extends BaseController
{
    public function __construct()
    {
        helper(['url', 'form']);
    }

    public function registrierteGegenstande()
    {
        $data['page_title'] = "Registrierte Gegenstände";
        $data['menuName'] = "gegenstande";
        

        return view('Gegenstand/registrierteGegenstande', $data);
    }

    public function gegenstandRegistrieren($gegenstandId = false)
    {
        $data['page_title'] = "Gegenstand registrieren";
        $data['menuName'] = "add";
        $data['menuTextName'] = "gegenstand";
        
        $data['gegenstandId'] = $gegenstandId;

        if($gegenstandId != false)
        {
            $gegenstand = GegenstandHelper::getById($gegenstandId);

            if($gegenstand == null)
            {
                $data['redirect'] = base_url("show-gegenstand/" . $gegenstandId);
            }
            
            $data['gegenstand'] = $gegenstand;
        }

        return view('Gegenstand/gegenstandRegistrieren', $data);
    }
}
