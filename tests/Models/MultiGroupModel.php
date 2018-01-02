<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Model;

class MultiGroupModel extends Model
{
	use Sequence;

    protected $table = 'simple_models';

	protected $fillable = ['name', 'group', 'group2', 'seq'];

	public function sequence()
	{
		return [
			'fieldName' => 'seq',
			'group' => ['group', 'group2'],
		];
	}

}
