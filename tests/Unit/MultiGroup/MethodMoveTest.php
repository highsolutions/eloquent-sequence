<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class MethodMoveTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_move_method_on_second_element_to_move_on_top_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->move(0);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_move_method_on_first_element_to_move_to_bottom_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->move(1);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_move_method_on_first_element_to_move_to_bottom_with_overflow_position_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->move(200);

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_move_method_in_between_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model4 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->move(3);

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(4, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
        $this->assertEquals(3, $model4->fresh()->seq);
    }
}
