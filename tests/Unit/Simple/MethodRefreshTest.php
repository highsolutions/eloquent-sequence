<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

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
}
