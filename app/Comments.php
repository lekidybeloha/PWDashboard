<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table        = 'carts_comments';
    protected $primaryKey   = 'id';

    public static function getByCart($id)
    {

        return self::where('id_dashboard_task', '=', $id)->get();

    }

    public static function create($verb)
    {
        $data['id_user']            = $verb->input('id_user');
        $data['id_dashboard_task']  = $verb->input('id_task');
        $data['comment']            = $verb->input('comment');
        $data['created_at']         = @date('Y-m-d H:i:s');
        $data['updated_at']         = @date('Y-m-d H:i:s');
        self::insert($data);
    }
}
