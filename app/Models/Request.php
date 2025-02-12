<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 * 
 * @property int $id_request
 * @property int $fk_user_prime
 * @property int $fk_statusRequest
 * @property string $request_code
 * @property string $request_applicantName
 * @property string $request_applicantEmail
 * @property string $request_tittle
 * @property string $request_description
 * @property Carbon $request_date_start
 * @property Carbon|null $request_date_finish
 * 
 * @property StatusRequest $status_request
 * @property User $user
 * @property Collection|RequestSolution[] $request_solutions
 * @property Collection|Attachment[] $attachments
 * @property Collection|User[] $users
 * @property Collection|Project[] $projects
 *
 * @package App\Models
 */
class Request extends Model
{
	protected $table = 'requests';
	protected $primaryKey = 'id_request';
	public $timestamps = false;

	protected $casts = [
		'fk_user_prime' => 'int',
		'fk_statusRequest' => 'int',
		'request_date_start' => 'datetime',
		'request_date_finish' => 'datetime'
	];

	protected $fillable = [
		'fk_user_prime',
		'fk_statusRequest',
		'request_code',
		'request_applicantName',
		'request_applicantEmail',
		'request_tittle',
		'request_description',
		'request_date_start',
		'request_date_finish'
	];

	public function status_request()
	{
		return $this->belongsTo(StatusRequest::class, 'fk_statusRequest');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'fk_user_prime');
	}

	public function request_solutions()
	{
		return $this->hasMany(RequestSolution::class, 'fk_request');
	}

	public function attachments()
	{
		return $this->belongsToMany(Attachment::class, 'requests_x_attachments', 'fk_request', 'fk_attachment')
					->withPivot('id_requestXattachmentl');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'users_projects_request', 'fk_request', 'fk_user')
					->withPivot('id_userProjectRequest', 'fk_project');
	}

	public function projects()
	{
		return $this->belongsToMany(Project::class, 'users_projects_request', 'fk_request', 'fk_project')
					->withPivot('id_userProjectRequest', 'fk_user');
	}
}
