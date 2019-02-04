<?php

namespace App\Http\Controllers;

use App\Etiquettes;
use App\TaskDetails;
use App\Lists;
use App\Organisms;
use App\Task;
use Illuminate\Http\Request;
use App\Dashboard;
use Illuminate\Support\Facades\Auth;

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
        $dashboard = Dashboard::getAllByUser(Auth::id());
        return view('home', [
                                    'dashboard'    =>   $dashboard,
                                    'id_user'      =>   Auth::id()
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
        return view('dashboard', [
                                            'dashboard' =>  $dashboard,
                                            'lists'     =>  $lists,
                                            'tasks'     =>  $tasks,
                                            'id_user'   =>   Auth::id()
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
