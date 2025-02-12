<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class FollowsRequest
 * 
 * @property int $id_followRequest
 * @property int $fk_UserProjectRequest
 * @property string $follow_userRegister
 * @property string $follow_description
 * @property Carbon $date_register
 * 
 * @property UsersProjectsRequest $users_projects_request
 *
 * @package App\Models
 */
class FollowsRequest extends Model
{
	protected $table = 'follows_requests';
	protected $primaryKey = 'id_followRequest';
	public $timestamps = false;

	protected $casts = [
		'fk_UserProjectRequest' => 'int',
		'date_register' => 'datetime'
	];

	protected $fillable = [
		'fk_UserProjectRequest',
		'follow_userRegister',
		'follow_description',
		'date_register'
	];

	public function users_projects_request()
	{
		return $this->belongsTo(UsersProjectsRequest::class, 'fk_UserProjectRequest');
	}
}
