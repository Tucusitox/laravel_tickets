<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Permission
 * 
 * @property int $id_permission
 * @property string $permission_name
 * 
 * @property Collection|Rol[] $rols
 *
 * @package App\Models
 */
class Permission extends Model
{
	protected $table = 'permissions';
	protected $primaryKey = 'id_permission';
	public $timestamps = false;

	protected $fillable = [
		'permission_name'
	];

	public function rols()
	{
		return $this->belongsToMany(Rol::class, 'rols_x_permissions', 'fk_permission', 'fk_rol')
					->withPivot('id_rolXpermission');
	}
}
