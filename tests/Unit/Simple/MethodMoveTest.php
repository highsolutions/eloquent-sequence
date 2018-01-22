<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;

class MethodMoveTest extends SequenceTestCase
{
    /** @test */
    public function use_move_method_on_second_element_to_move_on_top()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model2->move(0);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_move_method_on_first_element_to_move_to_bottom()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model1->move(1);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_move_method_on_first_element_to_move_to_bottom_with_overflow_position()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model1->move(200);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_move_method_in_between_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();
        $model4 = $this->newModel();

        $model2->move(3);

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(4, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
        $this->assertEquals(3, $model4->fresh()->seq);
    }
}
