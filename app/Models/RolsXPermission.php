<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RolsXPermission
 * 
 * @property int $id_rolXpermission
 * @property int $fk_rol
 * @property int $fk_permission
 * 
 * @property Permission $permission
 * @property Rol $rol
 *
 * @package App\Models
 */
class RolsXPermission extends Model
{
	protected $table = 'rols_x_permissions';
	protected $primaryKey = 'id_rolXpermission';
	public $timestamps = false;

	protected $casts = [
		'fk_rol' => 'int',
		'fk_permission' => 'int'
	];

	protected $fillable = [
		'fk_rol',
		'fk_permission'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class, 'fk_permission');
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class, 'fk_rol');
	}
}
