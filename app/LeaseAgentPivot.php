<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class LeaseAgentPivot extends Pivot
{
    protected $table = 'lease_agent';
}
