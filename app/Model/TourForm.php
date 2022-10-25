<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TourForm extends Model
{
    protected $table = 'tour_forms';

    protected $fillable = [
        "tour_id",
        "user_id",
        "amount_each_person",
        "number_of_list",
        "total_user",
        "first_name",
        "last_name",
        "number",
        "necessary_number",
        "national_code",
        "transaction_id"
    ];
}
