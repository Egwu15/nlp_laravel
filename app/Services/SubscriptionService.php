<?php

namespace App\Services;

use App\Models\AccessPlan;
use Illuminate\Database\Eloquent\Collection;

class SubscriptionService
{
    /**
     * @return Collection|AccessPlan
     */
    static public function allPlans(): Collection|AccessPlan
    {
        return AccessPlan::with(['laws', 'courtRules'])->where('active', 1)->get();
    }
}
