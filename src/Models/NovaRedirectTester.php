<?php

namespace Bernhardh\NovaRedirectTester\Models;

use Illuminate\Database\Eloquent\Model;

class NovaRedirectTester extends Model
{
    protected $table = "nova_redirect_tester";


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function redirectTesterGroup()
    {
        return $this->belongsTo(NovaRedirectTesterGroup::class, 'nova_redirect_tester_group_id', 'id');
    }
}
