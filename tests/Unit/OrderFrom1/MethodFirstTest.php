<?php

namespace HighSolutions\EloquentSequence\Test\Unit\OrderFrom1;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\OrderModel;

class MethodFirstTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(OrderModel::class);
    }

    /** @test */
    public function use_first_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model1->moveToFirst();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_first_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model2->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_first_method_on_third_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $model3->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(1, $model3->fresh()->seq);
    }
}
