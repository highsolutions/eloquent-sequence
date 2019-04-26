<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class MethodRefreshTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    /** @test */
    public function use_refresh_method_on_proper_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        MultiGroupModel::refreshSequence();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_not_ordered_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2->up();

        MultiGroupModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_incorrect_collection_with_one_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model1->update(['seq' => 3]);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2->update(['seq' => 0]);

        MultiGroupModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelB1 = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelB2 = $this->newModel(['group' => 'B', 'group2' => 'A']);

        MultiGroupModel::refreshSequence();

        $this->assertEquals(1, $modelA1->fresh()->seq);
        $this->assertEquals(2, $modelA2->fresh()->seq);
        $this->assertEquals(1, $modelB1->fresh()->seq);
        $this->assertEquals(2, $modelB2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_not_ordered_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelA2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelA2->up();

        $modelB1 = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelB2 = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelB1->down();

        MultiGroupModel::refreshSequence();

        $this->assertEquals(2, $modelA1->fresh()->seq);
        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(2, $modelB1->fresh()->seq);
        $this->assertEquals(1, $modelB2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_incorrect_collection_with_two_groups()
    {
        $modelA1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelA1->update(['seq' => 3]);
        $modelA2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $modelA2->update(['seq' => 0]);

        $modelB1 = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelB1->update(['seq' => 355]);
        $modelB2 = $this->newModel(['group' => 'B', 'group2' => 'A']);
        $modelB2->update(['seq' => -5]);

        MultiGroupModel::refreshSequence();

        $this->assertEquals(2, $modelA1->fresh()->seq);
        $this->assertEquals(1, $modelA2->fresh()->seq);
        $this->assertEquals(2, $modelB1->fresh()->seq);
        $this->assertEquals(1, $modelB2->fresh()->seq);
    }
}
