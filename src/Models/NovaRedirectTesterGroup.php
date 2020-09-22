<?php

namespace Bernhardh\NovaRedirectTester\Models;

use Illuminate\Database\Eloquent\Model;

class NovaRedirectTesterGroup extends Model
{
    protected $table = "nova_redirect_tester_groups";


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items() {
        return $this->hasMany(NovaRedirectTester::class, 'nova_redirect_tester_group_id', 'id');
    }
}
