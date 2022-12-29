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

        $data['errors'] = null;
        

        if($this->request->getMethod() == "post")
        {
            $validated = $this->validate([
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Bitte geben Sie einen Namen an'
                    ]
                ],
                'mail' => [
                    'rules' => 'valid_email',
                    'errors' => [
                        'valid_email' => 'Bitte geben Sie eine gültige Email Adresse an'
                    ]
                ],
            ]);

            if(!$validated)
            {
                $data['errors'] = $this->validator->getErrors();

                
                if($this->request->getPost('mail') == "")
                {
                    unset($data['errors']['mail']);
                }

                if(count($data['errors']) != 0)
                {
                    return view('Schueler/schuelerHinzufuegen', $data);
                }
            }

            //add schueler to db and redirect if validation has no errors
            echo('success');

            $name = $this->request->getPost('name');
            $mail = $this->request->getPost('mail');

            if($mail == "")
            {
                $mail = null;
            }

            SchuelerHelper::add($schuelerId, $name, $mail);
            return redirect()->to('add-gegenstand-to-leihgabe/' . $schuelerId);

        }


        return view('Schueler/schuelerHinzufuegen', $data);
    }
}
