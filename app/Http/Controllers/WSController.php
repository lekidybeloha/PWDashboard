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
use App\TaskFiles;
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
        $id_name = $verb->input('name');
        return Checklist::getByCarts($id_cart, $id_name);
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
        $data['id_dashboard']   = $verb->input('id_dashboard');
        $data['name']           = $verb->input('name');
        $data['color']          = $verb->input('color');
        return Etiquettes::create($data);
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
        $dashboard  = Dashboard::one($id);
        return view('components.etiquettes', [
                                            'etiquettes'=>  $etiquettes,
                                            'dashboard' =>  $dashboard
                                        ]);
    }

    public function createChecklist(Request $verb)
    {

        return Checklist::createChecklistName($verb);
    }

    public function getCartChecklistName(Request $verb)
    {
        return Checklist::getChecklistName($verb->input('id_cart'));
    }

    public function updateDueDate(Request $verb)
    {
        $data['id']         = $verb->input('id');
        $data['dueDate']    = $verb->input('due_date');
        return TaskDetails::updateDueDate($data);
    }

    public function getLists(Request $verb)
    {
        return Lists::getByIdDashboard($verb->input('id_dashboard'));
    }

    public function moveList(Request $verb)
    {
        $id_cart    = $verb->input('id_cart');
        $new_value  = $verb->input('position');
        return Lists::move($id_cart, $new_value);
    }

    public function archiveList(Request $verb)
    {
        return Lists::archive($verb->input('id'));
    }

    public function uploadFile(Request $verb)
    {
        $id_task = $verb->input('id_task');
        $path    = $verb->file('file')->store('public');
        TaskFiles::storeFiles($id_task, $path);

        return redirect()->route('dashboard', ['id' => $verb->input('id_dashboard')]);
    }

    public function getFiles(Request $verb)
    {
        return TaskFiles::getFiles($verb->input('id_cart'));
    }

}
