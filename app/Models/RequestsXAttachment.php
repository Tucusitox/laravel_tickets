<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestsXAttachment
 * 
 * @property int $id_requestXattachmentl
 * @property int $fk_request
 * @property int $fk_attachment
 * 
 * @property Attachment $attachment
 * @property Request $request
 *
 * @package App\Models
 */
class RequestsXAttachment extends Model
{
	protected $table = 'requests_x_attachments';
	protected $primaryKey = 'id_requestXattachmentl';
	public $timestamps = false;

	protected $casts = [
		'fk_request' => 'int',
		'fk_attachment' => 'int'
	];

	protected $fillable = [
		'fk_request',
		'fk_attachment'
	];

	public function attachment()
	{
		return $this->belongsTo(Attachment::class, 'fk_attachment');
	}

	public function request()
	{
		return $this->belongsTo(Request::class, 'fk_request');
	}
}
