<?php

namespace HighSolutions\EloquentSequence\Test;

use HighSolutions\EloquentSequence\Test\Models\SimpleModel;
use Illuminate\Support\Collection;

abstract class SequenceTestCase extends TestCase
{

	protected $class = SimpleModel::class;

	protected function setClass($class)
	{
		$this->class = $class;
	}

	protected function create($count, $params = [])
	{
		Collection::times($count, function ($number) use ($params) {
			$this->newModel($params, 'Model #'. $number);
		});
	}

	protected function newModel($params = [], $name = null)
	{
		return ($this->class)::create([
			'name' => $name ?: 'Model #'. ($this->class::count() + 1),
		] + $params);
	}

}
