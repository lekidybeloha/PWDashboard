<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Invitations extends Model
{
    //
    protected $table = 'invitations';

    public static function sendInvitation($verb)
    {
        $check = self::where('email', '=', $verb->input('email'))->where('id_dashboard', '=', $verb->input('id_dashboard'))->first();
        if($check)
        {
            return ['success' => FALSE, 'error' => 'Une invitation est déjà en attente pour cet email'];
        }

        $data['email']          = $verb->input('email');
        $data['id_dashboard']   = $verb->input('id_dashboard');
        $data['token']          = csrf_token();
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');

        $user = User::where('email', '=', $verb->input('email'))->first();

        if($user)
        {
            $res = Dashboard::addUserToDashboard($user->id, $verb->input('id_dashboard'));

            if($res)
            {
                Mail::raw('Vous avez été invité dans un tableau, identifiez vous pour accéder au tableau', function ($message) use ($verb)
                {
                    $message->from('elkana.dimbiniaina@hotmail.com', 'PWDashboard');
                    $message->to($verb->input('email'));
                });
            }

            return ['success' => TRUE];
        }

        self::insert($data);

        $link = route('confirmInvitation', ['email' =>  $data['email'], 'token' => $data['token']]);

        Mail::raw($verb->input('text'). 'Cliquez sur ce lien pour confirmer :'.$link, function ($message) use ($verb)
        {
            $message->from('elkana.dimbiniaina@hotmail.com', 'PWDashboard');
            $message->to($verb->input('email'));
        });

        return ['success' => TRUE];
    }

    public static function verifyInvitation($token)
    {
        $check = self::where('token', '=', $token)->first();
        if($check)
        {
            return ['success' => TRUE, 'id_dashboard' => $check->id_dashboard, 'email' => $check->email];
        }
        else
        {
            return ['success' => FALSE];
        }
    }
}
