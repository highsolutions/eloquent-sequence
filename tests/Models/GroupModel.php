<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use Illuminate\Database\Eloquent\Model;
use HighSolutions\EloquentSequence\Sequence;

class GroupModel extends Model
{
    use Sequence;

    protected $table = 'simple_models';

    protected $fillable = ['name', 'group', 'seq'];

    public function sequence()
    {
        return [
            'fieldName' => 'seq',
            'group' => 'group',
        ];
    }
}
