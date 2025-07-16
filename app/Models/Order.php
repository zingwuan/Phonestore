<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'customer_id','shipping_id','payment_method','order_total','order_status','created at'
    ];
    protected $primaryKey    = 'order_id';
    protected $table ='tbl_order';
}
