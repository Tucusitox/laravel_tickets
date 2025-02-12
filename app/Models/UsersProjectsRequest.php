<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UsersProjectsRequest
 * 
 * @property int $id_userProjectRequest
 * @property int $fk_user
 * @property int $fk_project
 * @property int $fk_request
 * 
 * @property User $user
 * @property Project $project
 * @property Request $request
 * @property Collection|FollowsRequest[] $follows_requests
 *
 * @package App\Models
 */
class UsersProjectsRequest extends Model
{
	protected $table = 'users_projects_request';
	protected $primaryKey = 'id_userProjectRequest';
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'fk_project' => 'int',
		'fk_request' => 'int'
	];

	protected $fillable = [
		'fk_user',
		'fk_project',
		'fk_request'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'fk_user');
	}

	public function project()
	{
		return $this->belongsTo(Project::class, 'fk_project');
	}

	public function request()
	{
		return $this->belongsTo(Request::class, 'fk_request');
	}

	public function follows_requests()
	{
		return $this->hasMany(FollowsRequest::class, 'fk_UserProjectRequest');
	}
}
