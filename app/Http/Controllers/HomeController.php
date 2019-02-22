<?php

namespace App\Http\Controllers;

use App\Etiquettes;
use App\Invitations;
use App\Lists;
use App\Organisms;
use App\Task;
use App\User;
use Illuminate\Http\Request;
use App\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dashboard      = Dashboard::getAllByUser(Auth::id());
        $dashboard_coop = Dashboard::getCooperativeTable(Auth::id());
        $favorites      = [];

        foreach($dashboard as $one)
        {
            if($one->favoris == 1)
            {
                $favorites[] = $one;
            }
        }

        return view('home', [
                                    'dashboard'         =>   $dashboard,
                                    'dashboard_coop'    =>   $dashboard_coop,
                                    'favorites'         =>   $favorites,
                                    'id_user'           =>   Auth::id()
                                ]);
    }

    public function add(Request $verb)
    {
        Dashboard::create($verb);
        return redirect()->route('home');
    }

    public function dashboard($id)
    {
        $dashboard  = Dashboard::one($id);
        $lists      = Lists::getByIdDashboard($id);
        $tasks      = Task::getByDashboardId($id);
        $etiquettes = Etiquettes::wsAllByDashboard($id);
        $coop       = Dashboard::getUserInDashboard(Auth::id());
        return view('dashboard', [
                                            'dashboard' =>  $dashboard,
                                            'lists'     =>  $lists,
                                            'tasks'     =>  $tasks,
                                            'id_user'   =>   Auth::id(),
                                            'etiquettes'=>  $etiquettes,
                                            'coop'      =>  $coop,
                                            'username'  =>  Auth::user()->name
                                        ]);
    }

    public function addList(Request $verb)
    {
        Lists::create($verb);
        return redirect()->route('dashboard', ['id' => $verb->input('id_dashboard')]);
    }

    public function addCard(Request $verb)
    {
        Task::create($verb);
        return redirect()->route('dashboard', ['id' => $verb->input('id_dashboard')]);
    }

    public function confirmInvitation($email, $token)
    {
        $res = Invitations::verifyInvitation($email, $token);
        if($res)
        {
            return view('invitations.register', [
                                                            'email'     => $email,
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

        $id = User::create($data);

        Dashboard::addUserToDashboard($id->id, $verb->input('dashboard'));

        $attempt = ['email' => $data['email'], 'password' => $verb->input('password')];

        if(Auth::attempt($attempt))
        {
            redirect()->route('dashboard', ['id' => $verb->input('dashboard')]);
        }
    }
}
