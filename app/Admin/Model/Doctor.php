<?php

namespace App\Admin\Model;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    use ModelTree, AdminBuilder;
    
}
