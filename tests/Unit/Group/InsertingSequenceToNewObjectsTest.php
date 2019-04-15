<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class InsertingSequenceToNewObjectsTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function adds_1_to_first_element()
    {
        $model = $this->newModel(['group' => 'A']);

        $this->assertEquals(1, $model->seq);
    }

    /** @test */
    public function adds_2_to_second_element_to_the_same_group()
    {
        $this->create(1, ['group' => 'A']);
        $model = $this->newModel(['group' => 'A']);

        $this->assertEquals(2, $model->seq);
    }

    /** @test */
    public function adds_2_to_second_element_to_different_group()
    {
        $this->create(1, ['group' => 'A']);
        $model = $this->newModel(['group' => 'B']);

        $this->assertEquals(1, $model->seq);
    }

    /** @test */
    public function adds_2_to_third_element_but_2_in_the_same_group()
    {
        $this->create(1, ['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model = $this->newModel(['group' => 'A']);

        $this->assertEquals(2, $model->seq);
    }
}
