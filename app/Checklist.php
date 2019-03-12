<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Checklist extends Model
{
    //
    protected $table        = 'carts_checklist';
    protected $primaryKey   = 'id';
    protected $fillable     = ['done'];
    static $table_child     = 'checklist_name';

    public static function getByCarts($id, $name)
    {
        $res = self::where('id_dashboard_task', '=', $id)->where('id_checklist_name', '=', $name)->get();
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
        $data['id_checklist_name']  = $verb->input('id_checklist_name');
        $data['done']               = 0;
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }

    public static function updateChecklist($id, $value)
    {
        self::find($id)->update(['done' =>  $value]);
    }

    public static function createChecklistName($verb)
    {
        $data['id_dashboard_task']  = $verb->input('id');
        $data['name']               = $verb->input('name');
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        DB::table(self::$table_child)->insert($data);
    }

    public static function getChecklistName($id)
    {
        return DB::table(self::$table_child)->where('id_dashboard_task', '=', $id)->get();
    }
}
