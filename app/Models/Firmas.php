<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firmas extends Model
{
    use HasFactory;
    protected $table        = "firmas";
    protected $connection   = 'mysql';

    protected $fillable = [
            'id',
            'firma',
            'id_historial',
            'id_user',
    ];
}
