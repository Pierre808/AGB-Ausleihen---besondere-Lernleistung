<?php

namespace App\Libraries;

use App\Models\LeihtModel;

class LeihtHelper
{
    public static function add($schueler_id, $gegenstand_id, $datum_start = false, $datum_ende = false, $aktiv = 1)
    {
        $datumStart = $datum_start;
        $datumEnde = $datum_ende;

        if($datum_start == false)
        {
            $datumStart = date("Y-m-d H:i:s");
        }
        if($datum_ende == false)
        {
            $datumEnde = null;
        }

        $data = [
            'schueler_id' => $schueler_id,
            'gegenstand_id' => $gegenstand_id,
            'datum_start' => $datumStart,
            'datum_ende' => $datumEnde,
            'aktiv'    => $aktiv,
        ];

        $leihtModel = new LeihtModel();

        // Inserts data and returns inserted row's primary key
        $leihtDbId = $leihtModel->insert($data);

        return $leihtDbId;
    }

    public static function getActiveByIds($schueler_id, $gegenstand_id)
    {
        $leihtModel = new LeihtModel();
        $leiht = $leihtModel->where("schueler_id", $schueler_id)->where('gegenstand_id', $gegenstand_id)->First();

        return $leiht;
    }

    public static function getById($id)
    {
        $leihtModel = new LeihtModel();
        $leiht = $leihtModel->where("id", $id)->First();

        return $leiht;
    }

    public static function getActiveDesc()
    {
        $leihtModel = new LeihtModel();

        $leiht = $leihtModel->where("aktiv", 1)->orderBy("datum_start", "DESC")->FindAll();

        return $leiht;
    }

}