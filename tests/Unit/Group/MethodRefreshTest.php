<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class MethodRefreshTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function use_refresh_method_on_proper_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        GroupModel::refreshSequence();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_not_ordered_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model2->up();

        GroupModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_incorrect_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model1->update(['seq' => 3]);
        $model2 = $this->newModel(['group' => 'A']);
        $model2->update(['seq' => 0]);

        GroupModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelB1 = $this->newModel(['group' => 'B']);
        $modelB2 = $this->newModel(['group' => 'B']);

        GroupModel::refreshSequence();

        $this->assertEquals(1, $modelA1->fresh()->seq);
        $this->assertEquals(2, $modelA2->fresh()->seq);
        $this->assertEquals(1, $modelB1->fresh()->seq);
        $this->assertEquals(2, $modelB2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_not_ordered_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelA2->up();

        $modelB1 = $this->newModel(['group' => 'B']);
        $modelB2 = $this->newModel(['group' => 'B']);
        $modelB1->down();

        GroupModel::refreshSequence();

        $this->assertEquals(2, $modelA1->fresh()->seq);
        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(2, $modelB1->fresh()->seq);
        $this->assertEquals(1, $modelB2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_incorrect_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A']);
        $modelA1->update(['seq' => 3]);
        $modelA2 = $this->newModel(['group' => 'A']);
        $modelA2->update(['seq' => 0]);

        $modelB1 = $this->newModel(['group' => 'B']);
        $modelB1->update(['seq' => 355]);
        $modelB2 = $this->newModel(['group' => 'B']);
        $modelB2->update(['seq' => -5]);

        GroupModel::refreshSequence();

        $this->assertEquals(2, $modelA1->fresh()->seq);
        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(2, $modelB1->fresh()->seq);
        $this->assertEquals(1, $modelB2->fresh()->seq);
    }
}
