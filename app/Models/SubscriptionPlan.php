<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SubscriptionPlan extends Model
{
    protected $fillable = ['key', 'name', 'requests_per_minute', 'description'];
}
