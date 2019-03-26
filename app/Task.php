<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table        = 'dashboard_task';
    protected $primaryKey   = 'id';

    public static function getByDashboardId($id)
    {
        $res = self::where('id_dashboard', '=', $id)->get();

        return $res;
    }

    public static function create($verb)
    {
        $data['name']           = $verb->input('name');
        $data['id_dashboard']   = $verb->input('id_dashboard');
        $data['id_cart']        = $verb->input('id_card');
        $data['archive']        = 0;
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        $id = self::insertGetId($data);
        TaskDetails::create($id);
    }
}
