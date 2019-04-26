<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class MethodDownTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    /** @test */
    public function use_down_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->down();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_down_method_on_last_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->down();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_down_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->down();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_down_method_on_first_element_with_3_elements_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'A', 'group2' => 'B']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->down();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(3, $model3->fresh()->seq);
    }
}
