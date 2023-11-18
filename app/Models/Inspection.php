<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;
    protected $table = "tms_inspections";

    protected $fillable = [
        'batche_id',
        'user_id',
        'classnum',
        'labsize',
        'electricity',
        'internet',
        'labbill',
        'labattandance',
        'computer',
        'router',
        'projectortv',
        'usinglaptop',
        'labsecurity',
        'labreagister',
        'classreagulrity',
        'teacattituted',
        'teaclabatten',
        'upojelaodit',
        'upozelamonotring',
        'remark'
    ];

}