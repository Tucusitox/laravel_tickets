<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Project
 * 
 * @property int $id_project
 * @property string $project_name
 * 
 * @property Collection|User[] $users
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class Project extends Model
{
	protected $table = 'projects';
	protected $primaryKey = 'id_project';
	public $timestamps = false;

	protected $fillable = [
		'project_name'
	];

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_projects_request', 'fk_project', 'fk_user')
					->withPivot('id_userProjectRequest', 'fk_request');
	}

	public function requests()
	{
		return $this->belongsToMany(Request::class, 'users_projects_request', 'fk_project', 'fk_request')
					->withPivot('id_userProjectRequest', 'fk_user');
	}
}
