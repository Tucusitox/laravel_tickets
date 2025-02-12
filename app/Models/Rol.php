<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rol
 * 
 * @property int $id_rol
 * @property string $rol_name
 * 
 * @property Collection|Permission[] $permissions
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Rol extends Model
{
	protected $table = 'rols';
	protected $primaryKey = 'id_rol';
	public $timestamps = false;

	protected $fillable = [
		'rol_name'
	];

	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'rols_x_permissions', 'fk_rol', 'fk_permission')
					->withPivot('id_rolXpermission');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'fk_rol');
	}
}
