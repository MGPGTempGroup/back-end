<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LeasePropertyTypePivot extends Pivot
{
    protected $table = 'lease_property_type';
}
