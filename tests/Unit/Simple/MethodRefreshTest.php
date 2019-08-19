<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use HighSolutions\EloquentSequence\Test\Models\TimestampsDisabledModel;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\SimpleModel;

class MethodRefreshTest extends SequenceTestCase
{
    /** @test */
    public function use_refresh_method_on_proper_collection()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        SimpleModel::refreshSequence();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_proper_not_ordered_collection()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model2->up();

        SimpleModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_refresh_method_on_incorrect_collection()
    {
        $model1 = $this->newModel();
        $model1->update(['seq' => 3]);
        $model2 = $this->newModel();
        $model2->update(['seq' => 0]);

        SimpleModel::refreshSequence();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function update_timestamps_on_refresh_by_default()
    {
        $model1 = $this->newModel();
        $model1->update(['seq' => 3]);
        $model2 = $this->newModel();
        $model2->update(['seq' => 0]);

        sleep(1);   // needed to have delay between creation and update

        SimpleModel::refreshSequence();

        $this->assertNotEquals($model1->created_at, $model1->fresh()->updated_at);
        $this->assertNotEquals($model2->created_at, $model2->fresh()->updated_at);
    }

    /** @test */
    public function not_update_timestamps_on_refresh_when_config_up()
    {
        $model1 = $this->newModel();
        $model1->update(['seq' => 3]);
        $model2 = $this->newModel();
        $model2->update(['seq' => 0]);

        sleep(1);   // needed to have delay between creation and update

        TimestampsDisabledModel::refreshSequence();

        $this->assertEquals($model1->created_at, $model1->fresh()->updated_at);
        $this->assertEquals($model2->created_at, $model2->fresh()->updated_at);
    }
}
