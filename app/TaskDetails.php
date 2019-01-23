<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskDetails extends Model
{
    //
    protected $table        = 'carts_details';
    protected $primaryKey   = 'id';

    public static function getByCarts($id)
    {
        $res = self::where('id_dashboard_task', '=', $id)->first();
        return $res;
    }

    public static function saveDetails($verb)
    {
        self::where('id_dashboard_task', '=', $verb->input('id'))->update(['description'=>$verb->input('description'), 'updated_at'=>@date('Y-m-d H:i:s')]);
    }

    public static function create($id)
    {
        $data['id_dashboard_task']  = $id;
        $data['description']        = '';
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }
}
