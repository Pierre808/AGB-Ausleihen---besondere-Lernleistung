<?php

namespace App\Controllers;

use App\Libraries\SchuelerHelper;
use App\Libraries\GegenstandHelper;
use App\Libraries\LeihtHelper;

class Home extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function index($code = false)
    {
        if($code != false)
        {
            echo($code);
            if(str_starts_with($code, getenv('SCHUELER_PREFIX')))
            {
                if(SchuelerHelper::getById($code) != null)
                {
                    return redirect()->to(base_url("add-gegenstand-to-leihgabe/".$code));
                }
                else
                {
                    return redirect()->to(base_url("add-schueler/".$code));
                }
            }
            else if(str_starts_with($code, getenv('GEGENSTAND_PREFIX')))
            {
                if(LeihtHelper::getActiveByGegenstandId($code) != null)
                {
                    return redirect()->to(base_url("gegenstand-zurueckgeben/".$code));
                }
            }
            return redirect()->to(base_url());
        }


        $data['page_title'] = "Home";
        $data['menuName'] = "home";
        
        $leihgaben = LeihtHelper::getUeberfaellig();
        
        for($i = 0; $i < count($leihgaben); $i++)
        {
            $leihgaben[$i]['schueler_name'] = SchuelerHelper::getById($leihgaben[$i]['schueler_id'])['name'];
            $leihgaben[$i]['gegenstand_bezeichnung'] = GegenstandHelper::getById($leihgaben[$i]['gegenstand_id'])['bezeichnung'];

            $leihgaben[$i]['formated_datum_ende'] = date_format(date_create_from_format("Y-m-d H:i:s", $leihgaben[$i]['datum_ende']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
        }

        $data['leihgaben'] = $leihgaben;

        return view('Home/index', $data);
    }
}
