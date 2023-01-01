<?php

namespace App\Controllers;

use App\Models\SchuelerModel;
use App\Models\GegenstandModel;

use App\Libraries\SchuelerHelper;
use App\Libraries\GegenstandHelper;
use App\Libraries\LeihtHelper;

class Leihgabe extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();
        
        helper(['url', 'form']);
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

    public function leihgabeAnzeigen($id = false)
    {
        if($id == false)
        {
            return view('errors/html/error_404');
        }
        


        $data['page_title'] = "Leihgabe";
        $data['menuName'] = "leihgaben";

        return view('Leihgabe/leihgabeAnzeigen', $data);
    }

    //nachdem der schuelerausweis eingescannt wurde, wird diese seite aufgerufen (siehe leihgabe erstellen)
    public function gegenstandHinzufuegen($schuelerId = false, $gegenstandId = false)
    {
        if($schuelerId == false)
        {
            return view('errors/html/error_404');
        }

        if($gegenstandId != false)
        {
            $gegenstand = GegenstandHelper::getById($gegenstandId);
            $data['gegenstand'] = $gegenstand;
            
            $data['alreadyInDb'] = false;

            $data['redirect'] = null;

            //found gegenstand and add it to leiht table in database
            if($gegenstand != null)
            {
                $dbEntry = LeihtHelper::getActiveByIds($schuelerId, $gegenstandId);
                
                if($dbEntry != null)
                {
                    $data['alreadyInDb'] = true;
                }
                else
                {
                    $rowId = LeihtHelper::add($schuelerId, $gegenstandId);


                    $data['redirect'] = base_url('show-leihgabe/' . $rowId);
                }
                
            }
        } 

        //search if schueler exists in db 
        //if not then redirect to addschueler page
        $schueler = SchuelerHelper::getById($schuelerId);

        if($schueler == null)
        {
            return redirect()->to('add-schueler/' . $schuelerId);
        }



        $data['page_title'] = "Leihgabe erstellen";
        $data['menuName'] = "add";
        $data['menuTextName'] = "leihgabe";

        $data['schuelerId'] = $schuelerId;
        $data['gegenstandId'] = $gegenstandId;

        $data['schuelerName'] = $schueler['name'];
        $mail = $schueler['mail'];
        if($schueler['mail'] == "")
        {
            $mail = "/";
        }
        $data['schuelerMail'] = $mail;

        return view('Leihgabe/gegenstandHinzufuegen', $data);
    }
}
