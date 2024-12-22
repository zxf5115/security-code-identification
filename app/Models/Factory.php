<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;

class Factory extends BaseModel
{

    use SearchScopeTrait;

    protected $guarded = [];

}
