<?php

namespace App\Http\Controllers;

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
}
