<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\Comments;
use App\Dashboard;
use App\Etiquettes;
use App\Invitations;
use App\TaskDetails;
use App\Lists;
use App\Task;
use Illuminate\Http\Request;

class WSController extends Controller
{
    //
    public function getListDetails(Request $verb)
    {
        $id_cart = $verb->input('id');
        return TaskDetails::getByCarts($id_cart);
    }

    public function saveCartDetails(Request $verb)
    {
        return TaskDetails::saveDetails($verb);
    }

    public function saveCartChecklist(Request $verb)
    {
        return Checklist::create($verb);
    }

    public function getCartChecklist(Request $verb)
    {
        $id_cart = $verb->input('id');
        return Checklist::getByCarts($id_cart);
    }

    public function updateChecklist(Request $verb)
    {
        $id_checklist = $verb->input('id');
        $value        = $verb->input('value');
        return Checklist::updateChecklist($id_checklist, $value);
    }

    public function updateList(Request $verb)
    {
        return Lists::updateData($verb);
    }

    public function getCartsComment(Request $verb)
    {
        $id_cart = $verb->input('id');
        return Comments::getByCart($id_cart);
    }

    public function saveComments(Request $verb)
    {
        return Comments::create($verb);
    }

    public function updateFavorite(Request $verb)
    {
        return Dashboard::updateFavoris($verb);
    }

    public function addEtiquette(Request $verb)
    {
        return Etiquettes::create($verb);
    }

    public function etiquettesList(Request $verb)
    {
        $id_dashboard   = $verb->input('id_dashboard');
        $id_task        = $verb->input('id_task');
        return Etiquettes::findEtiquetteInTask($id_dashboard, $id_task);
    }

    public function insertOrDeleteEtiquette(Request $verb)
    {
        $id     = $verb->input('id_etiquette');
        $task   = $verb->input('id_task');
        return Etiquettes::insertOrRemoveEtiquetteFromTask($id, $task);
    }

    public function updateMainDashboard($id)
    {
        $dashboard  = Dashboard::one($id);
        $lists      = Lists::getByIdDashboard($id);
        $tasks      = Task::getByDashboardId($id);
        return view('components.lists', [
                                                'lists'     =>  $lists,
                                                'tasks'     =>  $tasks,
                                                'dashboard' =>  $dashboard
                                            ]);
    }

    public function checkEtiquette(Request $verb)
    {
        $id_etiquette = $verb->input('id_etiquette');
        $id_dashboard_task = $verb->input('id_dashboard_task');
        return Etiquettes::findEtiquetteInTask($id_etiquette, $id_dashboard_task);
    }

    public function updateEtiquetteList($id)
    {
        $etiquettes = Etiquettes::wsAllByDashboard($id);
        return view('components.etiquettes', [
                                            'etiquettes'=>  $etiquettes
                                        ]);
    }

    public function sendInvitation(Request $verb)
    {
        return Invitations::sendInvitation($verb);
    }

}
