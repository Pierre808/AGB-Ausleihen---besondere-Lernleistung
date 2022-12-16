<?php

namespace App\Controllers;

use App\Models\SchuelerModel;

use App\Libraries\SchuelerHelper;

class Leihgabe extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function alleLeihgaben()
    {
        $data['page_title'] = "Alle Leihgabe";
        $data['menuName'] = "leihgaben";
        

        return view('Leihgabe/alleLeihgaben', $data);
    }

    public function leihgabeErstellen()
    {
        $data['page_title'] = "Leihgabe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "leihgabe";

        return view('Leihgabe/leihgabeErstellen', $data);
    }

    //nachdem der schuelerausweis eingescannt wurde, wird diese seite aufgerufen (siehe leihgabe erstellen)
    public function gegenstandHinzufuegen($schuelerId = false)
    {
        if($schuelerId == false)
        {
            return view('errors/html/error_404');
        }

        //search if schueler exists in db 
        //if not then redirect to addschueler page
        if(SchuelerHelper::getById($schuelerId) == null)
        {
            session()->setFlashdata('next-redirect', 'add-gegenstand-to-leihgabe/' . $schuelerId);
            return redirect()->to('add-schueler/' . $schuelerId);
        }

        $data['page_title'] = "Leihgabe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "leihgabe";

        return view('Leihgabe/gegenstandHinzufuegen', $data);
    }
}
