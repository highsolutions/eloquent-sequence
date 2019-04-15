<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class UpdatingSequencesAfterChangingObjectsGroupTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function sets_1_to_second_object_when_first_is_moved_to_an_other_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertEquals(2, $model2->seq);

        $model1->group = 'B';
        $model1->save();

        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_third_object_when_second_is_moved_to_an_other_group()
    {
        $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertEquals(3, $model3->seq);

        $model2->group = 'B';
        $model2->save();

        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function sets_1_to_first_object_when_moved_to_an_empty_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'A']);

        $this->assertEquals(1, $model1->seq);

        $model1->group = 'B';
        $model1->save();

        $this->assertEquals(1, $model1->fresh()->seq);
    }

    /** @test */
    public function sets_1_to_second_object_when_moved_to_an_empty_group()
    {
        $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertEquals(2, $model2->seq);

        $model2->group = 'B';
        $model2->save();

        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function sets_1_to_third_object_when_moved_to_an_empty_group()
    {
        $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertEquals(3, $model3->seq);

        $model3->group = 'B';
        $model3->save();

        $this->assertEquals(1, $model3->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_first_object_when_moved_to_a_not_empty_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'B']);

        $this->assertEquals(1, $model1->seq);

        $model1->group = 'B';
        $model1->save();

        $this->assertEquals(2, $model1->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_second_object_when_moved_to_a_not_empty_group()
    {
        $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'B']);

        $this->assertEquals(2, $model2->seq);

        $model2->group = 'B';
        $model2->save();

        $this->assertEquals(2, $model2->fresh()->seq);
    }
}
