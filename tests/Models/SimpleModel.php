<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use Illuminate\Database\Eloquent\Model;
use HighSolutions\EloquentSequence\Sequence;

class SimpleModel extends Model
{
    use Sequence;

    protected $table = 'simple_models';

    protected $fillable = ['name', 'seq'];

    public function sequence()
    {
        return [
            'fieldName' => 'seq',
        ];
    }
}
