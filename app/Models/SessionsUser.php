<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SessionsUser
 * 
 * @property int $id_sessionUser
 * @property int $fk_user
 * @property Carbon $session_date
 * @property Carbon $session_time_start
 * @property Carbon|null $session_time_closing
 * @property Carbon|null $session_duration
 * @property string $session_status
 * 
 * @property User $user
 *
 * @package App\Models
 */
class SessionsUser extends Model
{
	protected $table = 'sessions_users';
	protected $primaryKey = 'id_sessionUser';
	public $timestamps = false;

	protected $casts = [
		'fk_user' => 'int',
		'session_date' => 'datetime',
		'session_time_start' => 'datetime',
		'session_time_closing' => 'datetime',
		'session_duration' => 'datetime'
	];

	protected $fillable = [
		'fk_user',
		'session_date',
		'session_time_start',
		'session_time_closing',
		'session_duration',
		'session_status'
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'fk_user');
	}
}
