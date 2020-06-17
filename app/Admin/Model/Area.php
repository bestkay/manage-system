<?php

namespace App\Admin\Model;

use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use ModelTree, AdminBuilder;

    protected $table = 'areas';
    
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTitleColumn('name');
    }
}
