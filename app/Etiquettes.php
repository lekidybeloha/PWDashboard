<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Etiquettes extends Model
{
    //
    protected $table        = 'etiquettes';
    protected $primaryKey   = 'id';

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
}
