<?php

namespace App\Controllers;

use App\Libraries\GegenstandHelper;
use App\Libraries\SchuelerHelper;
use App\Libraries\LeihtHelper;

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
                GegenstandHelper::add($gegenstandId, '/');
                $data['redirect'] = base_url("show-gegenstand/" . $gegenstandId);
            }
            
            $data['gegenstand'] = $gegenstand;
        }

        return view('Gegenstand/gegenstandRegistrieren', $data);
    }

    public function gegenstandAnzeigen($gegenstandId)
    {
        $data['page_title'] = "Gegenstand Anzeigen";
        $data['menuName'] = "gegenstande";
        
        $gegenstand = GegenstandHelper::getById($gegenstandId);
        $data['gegenstand'] = $gegenstand;

        $activeLeihgabe = LeihtHelper::getActiveByGegenstandId($gegenstandId);
        $data['active'] = $activeLeihgabe;

        $allLeihgaben = LeihtHelper::getByGegenstandId($gegenstandId);
        
        for($i = 0; $i < count($allLeihgaben); $i++)
        {
            $allLeihgaben[$i]['formated_datum_start'] = date_format(date_create_from_format("Y-m-d H:i:s", $allLeihgaben[$i]['datum_start']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
            
            if($allLeihgaben[$i]['datum_ende'] == "")
            {
                $allLeihgaben[$i]['formated_datum_ende'] = "/";
            }
            else
            {
                $allLeihgaben[$i]['formated_datum_ende'] = date_format(date_create_from_format("Y-m-d H:i:s", $allLeihgaben[$i]['datum_ende']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
            }

            $schueler = SchuelerHelper::getById($allLeihgaben[$i]['schueler_id']);

            $allLeihgaben[$i]['schueler_name'] = $schueler['name'];
        
        }
        
        $data['verlauf'] = $allLeihgaben;



        if($this->request->getMethod() == "post")
        {
            //TODO: set bezeichnung?

            //prevent warning on reload caused by post request
            return redirect()->to("show-gegenstand/" . $gegenstandId);
        }

        return view('Gegenstand/gegenstandAnzeigen', $data);
    }
}
