<?php

namespace HighSolutions\EloquentSequence\Test\Models;

use Illuminate\Database\Eloquent\Model;
use HighSolutions\EloquentSequence\Sequence;

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
