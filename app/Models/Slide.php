<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'slide_name','slide_desc','slide_image','slide_status'
    ];
    protected $primaryKey = 'slide_id';
    protected $table ='tbl_slide';
}
