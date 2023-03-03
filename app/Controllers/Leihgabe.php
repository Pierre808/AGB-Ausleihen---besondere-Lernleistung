<?php

namespace App\Controllers;

use App\Models\SchuelerModel;
use App\Models\GegenstandModel;

use App\Libraries\SchuelerHelper;
use App\Libraries\GegenstandHelper;
use App\Libraries\LeihtHelper;


use DateTime;
use DateInterval;

class Leihgabe extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();
        
        helper(['url', 'form']);
    }

    public function alleLeihgaben()
    {
        $data['page_title'] = "Alle Leihgaben";
        $data['menuName'] = "leihgaben";
        
        $activeLeihgaben = LeihtHelper::getActiveDesc();

        for($i = 0; $i < count($activeLeihgaben); $i++)
        {
            $schueler = SchuelerHelper::getById($activeLeihgaben[$i]['schueler_id']);
            $activeLeihgaben[$i]['schueler_name'] = $schueler['name'];

            $gegenstand = GegenstandHelper::getById($activeLeihgaben[$i]['gegenstand_id']);
            $activeLeihgaben[$i]['gegenstand_bezeichnung'] = $gegenstand['bezeichnung'];

            $activeLeihgaben[$i]['formated_datum_start'] = date_format(date_create_from_format("Y-m-d H:i:s", $activeLeihgaben[$i]['datum_start']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
        }

        $data['active'] = $activeLeihgaben;

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
        
        $leihgabe = LeihtHelper::getById($id);
        if($leihgabe['datum_ende'] == "")
        {
            $leihgabe['formated_datum_ende'] = "/";
        }
        else
        {
            $leihgabe['formated_datum_ende'] = date_format(date_create_from_format("Y-m-d H:i:s", $leihgabe['datum_ende']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
        }

        $leihgabe['formated_datum_start'] = date_format(date_create_from_format("Y-m-d H:i:s", $leihgabe['datum_start']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");

        $leihgabe['zurueck_string'] = "Nein";
        $leihgabe['zurueck_color'] = "red";
        if($leihgabe['aktiv'] == 0)
        {
            $leihgabe['zurueck_string'] = "Ja";
            $leihgabe['zurueck_color'] = "green";
        }
        
        $schueler = SchuelerHelper::getById($leihgabe['schueler_id']);
        if($schueler['mail'] == "")
        {
            $schueler['mail'] = "/";
        }

        $gegenstand = GegenstandHelper::getById($leihgabe['gegenstand_id']);

        $data['leihgabe'] = $leihgabe;
        $data['schueler'] = $schueler;
        $data['gegenstand'] = $gegenstand;


        $data['page_title'] = "Leihgabe";
        $data['menuName'] = "leihgaben";

        return view('Leihgabe/leihgabeAnzeigen', $data);
    }

    //nachdem der schuelerausweis eingescannt wurde, wird diese seite aufgerufen (siehe leihgabe erstellen)
    public function gegenstandHinzufuegen($schuelerId = false, $gegenstandId = false, $weitere = false, $lehrer = false, $datumEnde = false)
    {
        if($schuelerId == false)
        {
            return view('errors/html/error_404');
        }

        if($gegenstandId != false)
        {
            $gegenstand = GegenstandHelper::getById($gegenstandId);
            $data['gegenstand'] = $gegenstand;

            $data['wrongprefix'] = false;
            if(!str_starts_with($gegenstandId, getenv('GEGENSTAND_PREFIX')))
            {
                $data['wrongprefix'] = true;
            }
            
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
                    $weitereCropped = substr($weitere, 8);
                    if($weitereCropped == "")
                    {
                        $weitereCropped = 0;
                    }

                    $lehrerCropped = substr($lehrer, 7);
                    if($lehrerCropped == "")
                    {
                        $lehrerCropped = "/";
                    }
                    
                    $d = false;
                    if($datumEnde != false)
                    {
                        $datumEndeCropped = trim($datumEnde, "datum-ende=");

                        if($datumEndeCropped != "")
                        {
                            $d = date("Y-m-d H:i:s", strtotime('+23 hours +59 minutes', strtotime($datumEndeCropped)));
                        }
                    }

                    
                    $rowId = LeihtHelper::add($schuelerId, $gegenstandId,date("Y-m-d H:i:s"), $d, $weitereCropped, $lehrerCropped);
                    
                    

                    $data['redirect'] = base_url('show-leihgabe/' . $rowId);
                }
                
            }
            else
            {
                session()->setFlashdata('gegenstand_redirect', 'add-gegenstand-to-leihgabe/' . $schuelerId . "/" . $gegenstandId);
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
