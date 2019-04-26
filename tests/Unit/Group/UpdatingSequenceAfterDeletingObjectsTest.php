<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class UpdatingSequenceAfterDeletingObjectsTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function sets_1_to_second_object_when_first_is_deleted_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertEquals(2, $model2->seq);

        $model1->delete();

        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_third_object_when_second_is_deleted_with_one_group()
    {
        $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertEquals(3, $model3->seq);

        $model2->delete();

        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function sets_sequence_lower_to_elements_after_deleted_object_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $model1->delete();

        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function sets_1_to_second_object_when_first_is_deleted_with_different_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelB1 = $this->newModel(['group' => 'B']);

        $this->assertEquals(2, $modelA2->seq);
        $this->assertEquals(1, $modelB1->seq);

        $modelA1->delete();

        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(1, $modelB1->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_third_object_when_second_is_deleted_with_different_groups()
    {
        $this->newModel(['group' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelA3 = $this->newModel(['group' => 'A']);
        $this->newModel(['group' => 'B']);

        $this->assertEquals(3, $modelA3->seq);

        $modelA2->delete();

        $this->assertEquals(2, $modelA3->fresh()->seq);
    }

    /** @test */
    public function sets_sequence_lower_to_elements_after_deleted_object_with_different_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelA3 = $this->newModel(['group' => 'A']);
        $modelB1 = $this->newModel(['group' => 'B']);
        $modelB2 = $this->newModel(['group' => 'B']);

        $modelA1->delete();

        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(2, $modelA3->fresh()->seq);
        $this->assertEquals(1, $modelB1->fresh()->seq);
        $this->assertEquals(2, $modelB2->fresh()->seq);
    }
}
