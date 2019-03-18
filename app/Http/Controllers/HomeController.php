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
        $id     = Dashboard::create($verb);
        $data   = ['#519839', '#d9b51c', '#cd8313', '#b04632', '#89609e', '#055a8c'];
        foreach($data as $one)
        {
            $data['id_dashboard']   = $id;
            $data['name']           = ' ';
            $data['color']          = $one;
            Etiquettes::create($data);
        }
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
}
