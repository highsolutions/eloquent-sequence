<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Model;

class ExceptionModel extends Model
{
	use Sequence;

    protected $table = 'simple_models';

	protected $fillable = ['name'];

	public function sequence()
	{
		return [
			'fieldName' => 'seq',
			'exceptions' => true,
		];
	}

}
