<?php

namespace App\Http\Controllers\Development;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class usuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $loggin_User = Auth()->User()->name;
        $users = User::all();
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Usuarios/consultar', compact('users', 'loggin_User', 'adminUser'));
    }
}
