<?php

namespace App\Controllers;

/*use App\Models\UserModel;*/

class Home extends BaseController
{
    public function __construct()
    {
        //$this->db = \Config\Database::connect();

    }

    public function index()
    {
        $data['page_title'] = "Home";
        

        return view('Home/index', $data);
    }
}
