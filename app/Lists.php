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

    public static function updateData($verb)
    {
        $data   = [];
        $update = $verb->all();
        foreach($update as $k=>$one)
        {
            if($k != 'id'){
                $data[$k] = $one;
            }

            if($k == 'title'){
                $data[$k] = urlencode($one);
            }
        }

        $res = self::where('id', '=', $update['id'])->update($data);
        if($res)
        {
            return ['success' => TRUE];
        }
        else
        {
            return ['success' => FALSE];
        }

    }
}
