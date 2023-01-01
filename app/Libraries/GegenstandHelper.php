<?php

namespace App\Libraries;

use App\Models\GegenstandModel;

class GegenstandHelper
{
    /*public static function add($id, $name, $mail = null)
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
    }*/

    public static function getById($id)
    {
        $gegenstandModel = new GegenstandModel();
        $gegenstand = $gegenstandModel->where("gegenstand_id", $id)->First();

        return $gegenstand;
    }

}