<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class InsertingSequenceToNewObjectsTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    /** @test */
    public function adds_1_to_first_element()
    {
        $model = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $this->assertEquals(1, $model->seq);
    }

    /** @test */
    public function adds_2_to_second_element_to_the_same_group()
    {
        $this->create(1, ['group' => 'A', 'group2' => 'A']);
        $model = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $this->assertEquals(2, $model->seq);
    }

    /** @test */
    public function adds_2_to_second_element_to_different_group()
    {
        $this->create(1, ['group' => 'A', 'group2' => 'A']);
        $model = $this->newModel(['group' => 'A', 'group2' => 'B']);

        $this->assertEquals(1, $model->seq);
    }

    /** @test */
    public function adds_2_to_third_element_but_2_in_the_same_group()
    {
        $this->create(1, ['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $modelAA = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelAB = $this->newModel(['group' => 'A', 'group2' => 'B']);
        $modelBA = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelBB = $this->newModel(['group' => 'B', 'group2' => 'B']);

        $this->assertEquals(2, $modelAA->seq);
        $this->assertEquals(1, $modelAB->seq);
        $this->assertEquals(2, $modelBA->seq);
        $this->assertEquals(1, $modelBB->seq);
    }
}
