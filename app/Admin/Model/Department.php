<?php

namespace App\Admin\Model;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

use App\Admin\Model\Patient;

class Department extends Model
{
    use ModelTree, AdminBuilder;

    public function patient()
    {
    	return $this->hasOne(Patient::class);
    }
}
