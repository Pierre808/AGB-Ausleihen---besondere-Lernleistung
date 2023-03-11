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
        $this->db = \Config\Database::connect();
        
        helper(['url', 'form']);
    }

    public function alleLeihgaben($filter=false)
    {
        $data['page_title'] = "Alle Leihgaben";
        $data['menuName'] = "leihgaben";
        
        $data['post'] = false;


        $leihgaben = LeihtHelper::getActiveDesc();

        if(session()->getFlashData('filter-post-schueler') != null)
        {
            $_POST['schueler'] = session()->getFlashData('filter-post-schueler');
            $_POST['active'] = "yes";
        }

        if($this->request->getMethod() == "post" || session()->getFlashData('filter-post-schueler') != null)
        {
            //SQL command
            $sql = "SELECT * FROM leiht";
            $filterErrors = [];
            $sqlWhere = false;



            $data['post'] = true;

            $data['active_checked'] = false;
            if($this->request->getPost('active') == "yes")
            {
                $data['active_checked'] = true;
                $sql .= " WHERE aktiv = 1";
                $sqlWhere = true;
            }

            $data['ueberfaellig_checked'] = false;
            if($this->request->getPost('ueberfaellig') == "yes")
            {
                $data['ueberfaellig_checked'] = true;
                
                if($sqlWhere)
                {
                    $sql .= " AND ";
                }
                else
                {
                    $sql .= " WHERE ";
                    $sqlWhere = true;
                }

                $sql .= "datum_ende IS NOT NULL AND datum_ende < '" . date("Y-m-d H:i:s") . "'";
            }

            

            
            if($this->request->getPost('schueler') != "")
            {
                $validSchueler = [];

                $schueler = SchuelerHelper::getAllNamesGrouped();
                for($i = 0; $i < count($schueler); $i++)
                {
                    if(str_contains(strtoupper($schueler[$i]['name']), strtoupper($this->request->getPost('schueler'))))
                    {
                        array_push($validSchueler, $schueler[$i]['schueler_id']);
                    }
                }

                if(count($validSchueler) == 0)
                {
                    array_push($filterErrors, "Keine Schüler mit diesem Namen gefunden");
                }
                else
                {
                    if($sqlWhere)
                    {
                        $sql .= " AND (";
                    }
                    else
                    {
                        $sql .= " WHERE (";
                        $sqlWhere = true;
                    }

                    for($i = 0; $i < count($validSchueler); $i++)
                    {
                        if($i != 0)
                        {
                            $sql .= " OR ";
                        }

                        $sql .= "schueler_id = '{$validSchueler[$i]}'";
                    }

                    $sql .= ")";
                }
            }
            if($this->request->getPost('lehrer') != "")
            {
                $validLehrer = [];

                $lehrer = LeihtHelper::getAllLehrer();
                for($i = 0; $i < count($lehrer); $i++)
                {
                    if(str_contains(strtoupper($lehrer[$i]['lehrer']), strtoupper($this->request->getPost('lehrer'))))
                    {
                        array_push($validLehrer, $lehrer[$i]['lehrer']);
                    }
                }

                if(count($validLehrer) == 0)
                {
                    array_push($filterErrors, "Keine Lehrer mit diesem Namen gefunden");
                }
                else
                {
                    if($sqlWhere)
                    {
                        $sql .= " AND (";
                    }
                    else
                    {
                        $sql .= " WHERE (";
                        $sqlWhere = true;
                    }

                    for($i = 0; $i < count($validLehrer); $i++)
                    {
                        if($i != 0)
                        {
                            $sql .= " OR ";
                        }

                        $sql .= "lehrer = '{$validLehrer[$i]}'";
                    }

                    $sql .= ")";
                }
            }
            if($this->request->getPost('gegenstand') != "")
            {
                $validGegenstaende = [];

                $gegenstaende = GegenstandHelper::getAllBezeichnungen();
                for($i = 0; $i < count($gegenstaende); $i++)
                {
                    if(str_contains(strtoupper($gegenstaende[$i]['bezeichnung']), strtoupper($this->request->getPost('gegenstand'))))
                    {
                        array_push($validGegenstaende, $gegenstaende[$i]['gegenstand_id']);
                    }
                }

                if(count($validGegenstaende) == 0)
                {
                    array_push($filterErrors, "Keine Gegenstände mit diesem Namen gefunden");
                }
                else
                {
                    if($sqlWhere)
                    {
                        $sql .= " AND (";
                    }
                    else
                    {
                        $sql .= " WHERE (";
                        $sqlWhere = true;
                    }

                    for($i = 0; $i < count($validGegenstaende); $i++)
                    {
                        if($i != 0)
                        {
                            $sql .= " OR ";
                        }

                        $sql .= "gegenstand_id = '{$validGegenstaende[$i]}'";
                    }

                    $sql .= ")";
                }
            }

            $data['sql'] = $sql;

            $db = db_connect();
            $query = $db->query($sql);

            $leihgaben = $query->getResult('array');
        }


        for($i = 0; $i < count($leihgaben); $i++)
        {
            $schueler = SchuelerHelper::getById($leihgaben[$i]['schueler_id']);
            $leihgaben[$i]['schueler_name'] = $schueler['name'];

            $gegenstand = GegenstandHelper::getById($leihgaben[$i]['gegenstand_id']);
            $leihgaben[$i]['gegenstand_bezeichnung'] = $gegenstand['bezeichnung'];

            $leihgaben[$i]['formated_datum_start'] = date_format(date_create_from_format("Y-m-d H:i:s", $leihgaben[$i]['datum_start']), "H:i \U\h" . '\r, \a\m ' . "d.m.Y");
        }

        $data['active'] = $leihgaben;


        $data['alleSchueler'] = SchuelerHelper::getAll();
        $data['alleGegenstände'] = GegenstandHelper::getAll();
        $data['alleLehrer'] = LeihtHelper::getAllLehrer();

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
                $dbEntry = LeihtHelper::getActiveByGegenstandId($gegenstandId);
                
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
