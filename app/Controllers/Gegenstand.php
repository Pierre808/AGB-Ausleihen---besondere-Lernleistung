<?php

namespace App\Controllers;

use App\Libraries\GegenstandHelper;
use App\Libraries\SchuelerHelper;
use App\Libraries\LeihtHelper;
use App\Models\SchadenModel;
use App\Models\HatSchadenModel;

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
        
        $gegenstaende = GegenstandHelper::getAll();
        $data['gegenstaende'] = $gegenstaende;
        
        return view('Gegenstand/registrierteGegenstande', $data);
    }

    public function gegenstandRegistrieren($gegenstandId = false)
    {
        $data['page_title'] = "Gegenstand registrieren";
        $data['menuName'] = "add";
        $data['menuTextName'] = "gegenstand";
        
        $data['gegenstandId'] = $gegenstandId;

        $data['wrongprefix'] = false;
        if(!str_starts_with($gegenstandId, getenv('GEGENSTAND_PREFIX')))
        {
            $data['wrongprefix'] = true;
        }

        if($gegenstandId != false)
        {
            $gegenstand = GegenstandHelper::getById($gegenstandId);

            if($gegenstand == null)
            {
                GegenstandHelper::add($gegenstandId, '/');
                $data['redirect'] = base_url("show-gegenstand/" . $gegenstandId);

                if(session()->getFlashdata('gegenstand_redirect') != null)
                {
                    $data['redirect'] = base_url(session()->getFlashdata('gegenstand_redirect'));
                    unset($_SESSION['gegenstand_redirect']);
                }
            }
            
            $data['gegenstand'] = $gegenstand;
        }

        if(session()->getFlashdata('gegenstand_redirect') != null)
        {
            session()->setFlashdata('gegenstand_redirect', session()->getFlashdata('gegenstand_redirect'));
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

        $hatSchadenM = new hatSchadenModel();
        $schaeden = $hatSchadenM->where('gegenstand_id', $gegenstandId)->FindAll();
        $data['schaeden'] = $schaeden;

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
            $newBezeichnung = $this->request->getPost('bezeichnung');

            GegenstandHelper::setBezeichnung($gegenstandId, $newBezeichnung);

            //prevent warning on reload caused by post request
            return redirect()->to("show-gegenstand/" . $gegenstandId);
        }

        return view('Gegenstand/gegenstandAnzeigen', $data);
    }

    public function barcodeBearbeiten($gegenstandId = false, $newId = false)
    {
        if($gegenstandId == false)
        {
            return view('errors/html/error_404');
        }

        $data['page_title'] = "Barcode neu zuweisen";
        $data['menuName'] = "gegenstand";
        
        $data['gegenstandId'] = $gegenstandId;
        $data['newId'] = $newId;

        $error = "";

        if($newId != false)
        {
            $gegenstand = GegenstandHelper::getById($newId);

            if($gegenstand != null)
            {
                $error = "Es ist bereits ein Gegenstand mit diesem Barcode registriert";
            }
            else if(!str_starts_with($newId, getenv('GEGENSTAND_PREFIX')))
            {
                $error = "Der Barcode entspricht nicht den Bedingungen eines Gegenstandes";
            }

            if($error != "")
            {
            }
            else
            {
                //update FK
                $gegenstandOld = GegenstandHelper::getById($gegenstandId);
                GegenstandHelper::add($newId, $gegenstandOld['bezeichnung']);
                
                $leiht = LeihtHelper::getBygegenstandId($gegenstandId);

                for($i = 0; $i < count($leiht); $i++)
                {
                    LeihtHelper::setGegenstandId($leiht[$i]['id'], $newId);
                }

                $schaedenModel = new HatSchadenModel();
                $schaeden = $schaedenModel->where('gegenstand_id', $gegenstandId)->FindAll();

                for($i = 0; $i < count($schaeden); $i++)
                {
                    $dbData = [
                        'gegenstand_id' => $newId,
                    ];
                    
                    $schaedenModel->update($schaeden[$i]['id'], $dbData);
                }

                GegenstandHelper::deleteGegenstand($gegenstandId);
            }
        }

        $data['error'] = $error;

        return view('Gegenstand/barcodeBearbeiten', $data);
    }

    public function gegenstandZurueckgeben($gegenstandId = false)
    {
        $data['page_title'] = "Barcode neu zuweisen";
        $data['menuName'] = "gegenstand";
        
        $data['gegenstandId'] = $gegenstandId;

        $error = "";

        if($gegenstandId != false)
        {
            $gegenstand = GegenstandHelper::getById($gegenstandId);
            $aktiveLeihgabe = LeihtHelper::getActiveByGegenstandId($gegenstandId);

            if(!str_starts_with($gegenstandId, getenv('GEGENSTAND_PREFIX')))
            {
                $error = "Der Barcode entspricht nicht den Bedingungen eines Gegenstandes";
            }
            else if($gegenstand == null)
            {
                $error = "Es ist kein Gegenstand mit diesem Barcode registriert";
            }
            else if($gegenstand != null && $aktiveLeihgabe == null)
            {
                $error = "Der Gegenstand ist aktuell nicht verliehen";
            }

            if($error == "")
            {
                LeihtHelper::setAktiv($aktiveLeihgabe['id'], 0);
                $schueler = SchuelerHelper::getById($aktiveLeihgabe['schueler_id']);
                session()->setFlashData('filter-post-schueler', $schueler['name']);
            }
        }

        $data['error'] = $error;

        return view('Gegenstand/gegenstandZurueckgeben', $data);
    }

    public function schadenHinzufuegen($gegenstandId = false, $schaden = false)
    {
        if($gegenstandId == false)
        {
            return view('errors/html/error_404');
        }

        $data['page_title'] = "Schaden hinzufügen";
        $data['menuName'] = "gegenstand";

        $data['gegenstandId'] = $gegenstandId;
        
        if($schaden != false)
        {
            $schadenM = new SchadenModel();
            $schadenDb = $schadenM->where('bezeichnung', $schaden)->Find();

            if($schadenDb == null)
            {
                return view('errors/html/error_404');
            }


            $hatSchadenM = new HatSchadenModel();

            $bereitsHinzugefuegt = $hatSchadenM->where('gegenstand_id', $gegenstandId)->where('bezeichnung', $schaden)->Find();
            if($bereitsHinzugefuegt == null)
            {
                $hatSchadenM->insert(
                    [
                        'gegenstand_id' => $gegenstandId,
                        'bezeichnung' => $schaden
                    ]
                );
            }

            return redirect()->to(base_url('show-gegenstand/' . $gegenstandId));
        }


        $hatSchaden = new HatSchadenModel();
        $schaeden = $hatSchaden->where('gegenstand_id', $gegenstandId)->FindAll();

        $schadenM = new SchadenModel();
        $restlicheSchaeden = $schadenM->FindAll();

        for($i = 0; $i < count($schaeden); $i++)
        {
            $schaeden[$i]['bezeichnungUpper'] = ucfirst($schaeden[$i]['bezeichnung']);
            for($j = 0; $j < count($restlicheSchaeden); $j++)
            {
                if($schaeden[$i]['bezeichnung'] == $restlicheSchaeden[$j]['bezeichnung'])
                {
                    unset($restlicheSchaeden[$j]);
                    $restlicheSchaeden = array_values($restlicheSchaeden);
                }
            }
        }

        for($i = 0; $i < count($restlicheSchaeden); $i++)
        {
            $restlicheSchaeden[$i]['bezeichnungUpper'] = ucfirst($restlicheSchaeden[$i]['bezeichnung']);
        }

        $data['schaeden'] = $schaeden;
        $data['restlicheSchaeden'] = $restlicheSchaeden;

        return view('Gegenstand/schadenHinzufuegen', $data);
    }

    public function schadenEntfernen($gegenstandId = false, $schaden = false)
    {
        if($gegenstandId == false)
        {
            return view('errors/html/error_404');
        }
        if($schaden == false)
        {
            return view('errors/html/error_404');
        }

        $hatSchadenM = new hatSchadenModel();
        $vorhanden = $hatSchadenM->where('gegenstand_id', $gegenstandId)->where('bezeichnung', $schaden)->Find();

        if($vorhanden != null)
        {
            $hatSchadenM->delete($vorhanden[0]['id']);
        }
        return redirect()->to(base_url('show-gegenstand/' . $gegenstandId));
    }
}
