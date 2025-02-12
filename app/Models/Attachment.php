<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Attachment
 * 
 * @property int $id_attachment
 * @property string $attachment_route
 * 
 * @property Collection|Request[] $requests
 *
 * @package App\Models
 */
class Attachment extends Model
{
	protected $table = 'attachments';
	protected $primaryKey = 'id_attachment';
	public $timestamps = false;

	protected $fillable = [
		'attachment_route'
	];

	public function requests()
	{
		return $this->belongsToMany(Request::class, 'requests_x_attachments', 'fk_attachment', 'fk_request')
					->withPivot('id_requestXattachmentl');
	}
}
