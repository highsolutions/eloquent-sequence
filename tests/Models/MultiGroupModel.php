<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use Illuminate\Database\Eloquent\Model;
use HighSolutions\EloquentSequence\Sequence;

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
