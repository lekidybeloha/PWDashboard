<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Invitations;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    //
    public function confirmInvitation($token)
    {
        $res = Invitations::verifyInvitation($token);
        if($res['success'] == TRUE)
        {
            return view('invitations.register', [
                'email'     => $res['email'],
                'token'     => $token,
                'dashboard' => $res['id_dashboard']
            ]);
        }
        else
        {
            return view('invitations.expired');
        }
    }

    public function confirm(Request $verb)
    {
        $data['name']       = $verb->input('name');
        $data['email']      = $verb->input('email');
        $data['password']   = Hash::make($verb->input('password'));
        $data['token']      = $verb->input('token');

        $check = Invitations::verifyEmailAndToken($data['email'], $data['token']);

        if(!$check)
        {
            return view('invitations.expired');
        }

        $id = User::create($data);

        Dashboard::addUserToDashboard($id->id, $verb->input('dashboard'));

        $attempt = ['email' => $data['email'], 'password' => $verb->input('password')];

        if(Auth::attempt($attempt))
        {
            redirect()->route('home');
        }
    }

    public function sendInvitation(Request $verb)
    {
        return Invitations::sendInvitation($verb);
    }
}
