<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StatusRequest
 * 
 * @property int $id_statusRequest
 * @property string $status_name
 * 
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class StatusRequest extends Model
{
	protected $table = 'status_requests';
	protected $primaryKey = 'id_statusRequest';
	public $timestamps = false;

	protected $fillable = [
		'status_name'
	];

	public function requests()
	{
		return $this->hasMany(Request::class, 'fk_statusRequest');
	}
}
