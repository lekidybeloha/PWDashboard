<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $table        = 'dashboard_task';
    protected $primaryKey   = 'id';

    public static function getByDashboardIdAndStatus($id, $status)
    {
        $res = self::where('id_dashboard', '=', $id)->where('status', '=', $status)->get();

        return $res;
    }

    public static function create($verb)
    {
        $data['name']           = $verb->input('name');
        $data['id_dashboard']   = $verb->input('dashboard');
        $data['status']         = $verb->input('status');
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        self::insert($data);
    }
}
