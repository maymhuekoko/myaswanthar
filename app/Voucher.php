<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{

	use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [

    	'voucher_code',
    	'total_price',
    	'total_quantity',
    	'sale_by',
    	'type',
    	'voucher_date',
    	'status',
    	'order_id',
    	'sales_customer_id',
    	'sales_customer_name',
    	'deleted_at'
    ];

    public function counting_unit() {
        return $this->belongsToMany(CountingUnit::class)->withPivot('quantity','price');
    }

    public function user()
    {
        return $this->belongsTo('App\User','sale_by');
    }
    
    public function order() {
        return $this->belongsTo('App\Order');
    }
}

