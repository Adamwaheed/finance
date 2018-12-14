<?php

namespace Atolon\Finance\Models;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    public $fillable = [
        'data_type',
        'current_number',
        'prefix',
        'post_fix',
        'template',
        'date',
        'initial_number',
        'reset_by',
        'type',
    ];
}
