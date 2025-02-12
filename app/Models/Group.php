<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * 
 * @property int $id_group
 * @property string $group_name
 * @property string $group_description
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Group extends Model
{
	protected $table = 'groups';
	protected $primaryKey = 'id_group';
	public $timestamps = false;

	protected $fillable = [
		'group_name',
		'group_description'
	];

	public function users()
	{
		return $this->hasMany(User::class, 'fk_group');
	}
}
