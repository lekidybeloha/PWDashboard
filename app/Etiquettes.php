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
}
