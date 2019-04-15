<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\ExceptionModel;

class MethodUpTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(ExceptionModel::class);
    }

    /** @test */
    public function use_up_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->expectException(ModelNotFoundException::class);
        $model1->up();
    }

    /** @test */
    public function use_up_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model2->up();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_up_method_on_third_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $model3->up();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }
}
