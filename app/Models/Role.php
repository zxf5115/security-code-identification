<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;

class Role extends \Spatie\Permission\Models\Role
{

    use SearchScopeTrait;

    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        $this->setTable(config('permission.table_names.roles'));
    }
}
