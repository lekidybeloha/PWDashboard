<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    //
    protected $table        = 'carts_checklist';
    protected $primaryKey   = 'id';
    protected $fillable     = ['done'];

    public static function getByCarts($id)
    {
        $res = self::where('id_dashboard_task', '=', $id)->get();
        if(count($res)){
            return $res;
        }
        return [];
    }

    public static function create($verb)
    {
        $data['id_dashboard_task']  = $verb->input('id_card');
        $data['id_user']            = $verb->input('id_user');
        $data['name']               = $verb->input('name');
        $data['done']               = 0;
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }

    public static function updateChecklist($id, $value)
    {
        self::find($id)->update(['done' =>  $value]);
    }
}
