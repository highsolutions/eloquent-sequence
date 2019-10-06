<?php

namespace HighSolutions\EloquentSequence\Test\Unit\OrderFrom1;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\OrderModel;

class MethodsFirstLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(OrderModel::class);
    }

    /** @test */
    public function use_is_first_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model1->isFirst());
    }

    /** @test */
    public function use_is_first_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model2->isFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model1->isNotFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model2->isNotFirst());
    }

// LAST

    /** @test */
    public function use_is_last_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model1->isLast());
    }

    /** @test */
    public function use_is_last_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model2->isLast());
    }

    /** @test */
    public function use_is_not_last_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model1->isNotLast());
    }

    /** @test */
    public function use_is_not_last_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model2->isNotLast());
    }
}
