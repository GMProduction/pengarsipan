<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\User;

class UserController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        $user = User::all();
        return view('user')->with([
            'user' => $user
        ]);
    }

    public function create() {

    }
}
