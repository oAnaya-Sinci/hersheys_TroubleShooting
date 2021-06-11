<?php

namespace App\Http\Controllers\Development;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        $users = User::select(User::raw('id, name, email, IF(admin_user = 1, "True", "False") AS admin_user_text, admin_user, created_at'))->where('id', '<>', '1')->get();
        $adminUser = Auth()->User()->admin_user;

        return view('Development/Usuarios/consultar', compact('users', 'loggin_User', 'adminUser'));
    }

    public function dataTable(){

        $users = User::select(User::raw('id, name, email, IF(admin_user = 1, "True", "False") AS admin_user_text, admin_user, created_at'))->get();

        return json_encode($users);
    }

    public function updateDataUser(Request $userData){

        $data = $userData['data'];

        if($data['newPassword'] == NULL){

            User::where('id', '=', $data['idUser'])
            ->update([
                'name' => $data['nombreUser'],
                'admin_user' => $data['adminUser'] == 'True' ? 1 : 0,
            ]);
        }

        else{

            User::where('id', '=', $data['idUser'])
            ->update([
                'name' => $data['nombreUser'],
                'admin_user' => $data['adminUser'] == 'True' ? 1 : 0,
                'password' => Hash::make($data['newPassword'])
            ]);
        }

        return false;
    }

    public function deleteDataUser(Request $userId){

        $data = $userId['data'];

        if( (int)$data['idUser'] != Auth()->User()->id )
            User::where('id', '=', $data['idUser'])->delete();

        return true;
    }
}
