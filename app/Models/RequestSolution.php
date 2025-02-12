<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestSolution
 * 
 * @property int $id_requestSolution
 * @property int $fk_request
 * @property string $solution_userName
 * @property string $solution_tittle
 * @property string $solution_description
 * @property Carbon $solution_time
 * 
 * @property Request $request
 *
 * @package App\Models
 */
class RequestSolution extends Model
{
	protected $table = 'request_solutions';
	protected $primaryKey = 'id_requestSolution';
	public $timestamps = false;

	protected $casts = [
		'fk_request' => 'int',
		'solution_time' => 'datetime'
	];

	protected $fillable = [
		'fk_request',
		'solution_userName',
		'solution_tittle',
		'solution_description',
		'solution_time'
	];

	public function request()
	{
		return $this->belongsTo(Request::class, 'fk_request');
	}
}
