<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use HighSolutions\EloquentSequence\Sequence;
use Illuminate\Database\Eloquent\Model;

class OrderModel extends Model
{
	use Sequence;

    protected $table = 'simple_models';

	protected $fillable = ['name'];

	public $exceptionsParam = false;

	public function sequence()
	{
		return [
			'fieldName' => 'seq',
			'exceptions' => $this->exceptionsParam,
			'orderFrom1' => true,
		];
	}

}
