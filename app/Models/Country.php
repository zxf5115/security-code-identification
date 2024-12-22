<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;

class Country extends BaseModel
{
  use SearchScopeTrait;

  protected $guarded = [];

}
