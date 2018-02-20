<?php

namespace HighSolutions\EloquentSequence\Test;

use HighSolutions\EloquentSequence\Test\Models\SimpleModel;

abstract class SequenceTestCase extends TestCase
{
    protected $class = SimpleModel::class;

    protected function setClass($class)
    {
        $this->class = $class;
    }

    protected function create($count, $params = [])
    {
        for ($i = 0; $i < $count; $i++) {
            $this->newModel($params, 'Model #'.($i + 1));
        }
    }

    protected function newModel($params = [], $name = null)
    {
        return ($this->class)::create([
            'name' => $name ?: 'Model #'.($this->class::count() + 1),
        ] + $params);
    }
}
