<?php

namespace App\Http\Controllers;

use App\Checklist;
use App\TaskDetails;
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
}
