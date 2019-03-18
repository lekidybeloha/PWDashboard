<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Etiquettes extends Model
{
    //
    protected $table        = 'etiquettes';
    protected $primaryKey   = 'id';
    static $table_child     = 'etiquettes_task';

    public static function wsAllByDashboard($id)
    {
        return self::where('id_dashboard', '=', $id)->get();
    }

    public static function wsAllByCarts($id_task)
    {
        $data = [];
        $temp = DB::table('etiquettes_task')->where('id_dashboard_task', '=', $id_task)->get();
        if(count($temp))
        {
            foreach ($temp as $one)
            {
                $data[] = self::find($one->id_etiquette);
            }
        }

        return $data;
    }

    public static function create($verb)
    {
        $data['id_dashboard']   = $verb['id_dashboard'];
        $data['name']           = $verb['name'];
        $data['color']          = $verb['color'];
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        $res = self::insert($data);
        if($res)
        {
            return ['success'   =>  TRUE];
        }
        else
        {
            return ['success'   =>  FALSE];
        }
    }

    public static function findEtiquetteInTask($id, $id_task)
    {
        $res = DB::table(self::$table_child)->where('id_etiquette', '=', $id)->where('id_dashboard_task', '=', $id_task)->first();
        if($res)
        {
            return ['success' => TRUE, 'name' => self::find($id)];
        }
        else
        {
            return ['success' => FALSE];
        }
    }

    public static function insertOrRemoveEtiquetteFromTask($id, $id_task)
    {
        $res = DB::table(self::$table_child)->where('id_etiquette', '=', $id)->where('id_dashboard_task', '=', $id_task)->first();

        if($res)
        {
            DB::table(self::$table_child)->where('id_etiquette', '=', $id)->where('id_dashboard_task', '=', $id_task)->delete();
            return[
                'success'   =>  TRUE,
                'erase'     => TRUE
            ];
        }
        else
        {
            $data['id_etiquette']       = $id;
            $data['id_dashboard_task']  = $id_task;
            DB::table(self::$table_child)->insert($data);
            return[
                    'success'   =>  TRUE,
                    'erase'     => FALSE
                ];
        }
    }

    public static function getEtiquettesByCarts($id)
    {
        $data   = [];
        $res    = DB::table(self::$table_child)->where('id_dashboard_task', '=', $id)->get();
        if(count($res))
        {
            foreach($res as $one)
            {
                $data[] = self::find($one->id_etiquette);
            }
        }
        return $data;
    }
}
