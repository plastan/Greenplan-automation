<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class CustomerMealAssignments extends Model
{

    protected $fillable= [
        'customer_id',
        'menu_item_id',
        'delivery_status',
    ];

}
