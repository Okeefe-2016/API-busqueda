<?php
/**
 * Created by PhpStorm.
 * User: lucas
 * Date: 17/8/16
 * Time: 9:36 AM
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{

    protected $table = 'fotos';

    protected $primary_key = 'id_foto';

    public function getFotoAttribute()
    {
        return env('PUBLIC_URL') . $this->attributes['foto'];
    }
}