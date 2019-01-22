<?php

namespace App\Http\Controllers;

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
        $toDo       = Task::getByDashboardIdAndStatus($id, 1);
        $doing      = Task::getByDashboardIdAndStatus($id, 2);
        $done       = Task::getByDashboardIdAndStatus($id, 3);
        $archives   = Task::getByDashboardIdAndStatus($id, 4);
        return view('dashboard', [
                                            'dashboard' =>  $dashboard,
                                            'toDo'      =>  $toDo,
                                            'doing'     =>  $doing,
                                            'done'      =>  $done,
                                            'archives'  =>  $archives,
                                        ]);
    }

    public function addCard(Request $verb)
    {
        Task::create($verb);
        return redirect()->route('dashboard', ['id' => $verb->input('dashboard')]);
    }
}
