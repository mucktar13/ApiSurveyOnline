<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answers15a extends Model
{
    protected $table = 'answers15a';

    protected $primaryKey = 'id';

    protected $dateFormat = 'Y-m-d H:i:s';

    protected $connection = 'mysql';

    protected $fillable = ['id_answer'];

    public function Answers()
    {
        return $this->belongsTo('App\Answers', 'id_answer', 'id');
    }

}
