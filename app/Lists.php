<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    //
    protected $table        = 'carts';
    protected $primaryKey   = 'id';

    public static function getByIdDashboard($id)
    {
        $res = self::where('id_dashboard', '=', $id)->get();

        return $res;
    }

    public static function create($verb)
    {
        $data['id_dashboard']   = $verb->input('id_dashboard');
        $data['title']          = $verb->input('title');
        $data['color']          = 'none';
        self::insert($data);
    }
}
