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
        $data['menuName'] = "home";
        

        return view('Home/index', $data);
    }
}
