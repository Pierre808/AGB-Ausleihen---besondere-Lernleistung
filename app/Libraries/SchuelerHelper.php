<?php

namespace App\Libraries;

use App\Models\SchuelerModel;

class SchuelerHelper
{
    public static function getById($id)
    {
        $schuelerModel = new SchuelerModel();
        $schueler = $schuelerModel->where("schueler_id", $id)->First();

        return $schueler;
    }

}