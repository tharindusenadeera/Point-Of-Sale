<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'billing_address_1',
        'billing_address_2',
        'billing_city_id',
        'delivery_address_line_1',
        'delivery_address_line_2',
        'status',
        'discount_type',
        'discount_value',
        'tracking_code',
        'order_type',
        'user_id',
        'total',
        'litchen_user_id',
        'customer_id',
        'delivery_city_id',
        'billing_city_id',
        'delivery_first_name',
        'delivery_last_name',
        'delivery_phone_number',
        
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    /*protected $hidden = [
        'password',
    ];*/

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'orders';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    // public $timestamps = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    //const CREATED_AT = 'creation_date';
    //const UPDATED_AT = 'updated_date';

    public function ordermenuitems()
    {
        return $this->hasMany(OrderMenuItem::class);
    }

    public function customer()
    {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    
}
