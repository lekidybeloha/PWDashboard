<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    //
    protected $table        = 'dashboard';
    protected $primaryKey   = 'id';

    public static function one($id)
    {
        return self::find($id);
    }

    public static function getAllByUser($id)
    {
        $res = self::where(['id_user' => $id])->get();

        return $res;
    }

    public static function create($verb)
    {
        $data['name']           = $verb->input('name');
        $data['id_user']        = $verb->input('user');
        $data['privacy']        = $verb->input('privacy');
        $data['created_at']     = @date('Y-m-d H:i:s');
        $data['updated_at']     = @date('Y-m-d H:i:s');
        self::insert($data);
    }
}
