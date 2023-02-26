<?php

namespace App\Libraries;

use App\Models\SchuelerModel;

class SchuelerHelper
{
    public static function getAll()
    {
        $schuelerModel = new SchuelerModel();
        $schueler = $schuelerModel->FindAll();

        return $schueler;
    }
    
    public static function setName($id, $name)
    {
        $dbData = [
            'name' => $name,
        ];
        
        $schuelerModel = new SchuelerModel();

        $schuelerModel->update($id, $dbData);
    }

    public static function add($id, $name, $mail = null)
    {
        $data = [
            'schueler_id' => $id,
            'name' => $name,
            'mail'    => $mail,
        ];

        $schuelerModel = new SchuelerModel();

        // Inserts data and returns inserted row's primary key
        $schuelerDbId = $schuelerModel->insert($data);

        return $schuelerDbId;
    }

    public static function getById($id)
    {
        $schuelerModel = new SchuelerModel();
        $schueler = $schuelerModel->where("schueler_id", $id)->First();

        return $schueler;
    }

}