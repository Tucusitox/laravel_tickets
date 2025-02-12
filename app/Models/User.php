<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $user_id
 * @property int $fk_rol
 * @property int $fk_group
 * @property string $user_code
 * @property int $user_identification
 * @property string $user_gender
 * @property string $user_name
 * @property string $user_lastName
 * @property string $email
 * @property string $password
 * @property Carbon $user_dateOfBirth
 * @property string $user_status
 * 
 * @property Group $group
 * @property Rol $rol
 * @property Collection|Request[] $requests
 * @property Collection|SessionsUser[] $sessions_users
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	use Notifiable;
	
	protected $table = 'users';
	protected $primaryKey = 'user_id';
	public $timestamps = false;

	protected $casts = [
		'fk_rol' => 'int',
		'fk_group' => 'int',
		'user_identification' => 'int',
		'user_dateOfBirth' => 'datetime'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'fk_rol',
		'fk_group',
		'user_code',
		'user_identification',
		'user_gender',
		'user_name',
		'user_lastName',
		'email',
		'password',
		'user_dateOfBirth',
		'user_status'
	];

	public function group()
	{
		return $this->belongsTo(Group::class, 'fk_group');
	}

	public function rol()
	{
		return $this->belongsTo(Rol::class, 'fk_rol');
	}

	public function requests()
	{
		return $this->belongsToMany(Request::class, 'users_projects_request', 'fk_user', 'fk_request')
					->withPivot('id_userProjectRequest', 'fk_project');
	}

	public function sessions_users()
	{
		return $this->hasMany(SessionsUser::class, 'fk_user');
	}

	public function projects()
	{
		return $this->belongsToMany(Project::class, 'users_projects_request', 'fk_user', 'fk_project')
					->withPivot('id_userProjectRequest', 'fk_request');
	}
}
