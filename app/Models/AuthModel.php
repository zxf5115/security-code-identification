<?php
namespace App\Models;

use App\TraitClass\SearchScopeTrait;
use  Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AuthModel extends Authenticatable
{
    use HasRoles, Notifiable, SearchScopeTrait;
}
