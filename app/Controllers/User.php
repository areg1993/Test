<?php


namespace App\Controllers;


use App\Core\Auth;
use App\Core\Request;

class User extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function signIn(Request $request)
    {
        if(Auth::isLogged()){
            return $this->redirect('/',301);
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $auth = new Auth();
        $result = $auth->authenticate($request->post('name'), $request->post('password'));
        if ($result) {
            return $this->response([
                'success' => true
            ])->json();
        }

        return $this->response([
            'success' => false
        ],403)->json();
    }

    public function logout()
    {
        Auth::clearSession();
        return $this->response()->redirect("/sign_in",302);
    }

}