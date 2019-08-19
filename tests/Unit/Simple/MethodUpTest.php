<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use HighSolutions\EloquentSequence\Test\Models\TimestampsDisabledModel;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;

class MethodUpTest extends SequenceTestCase
{
    /** @test */
    public function use_up_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model1->up();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_up_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $model2->up();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_up_method_on_third_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $model3->up();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function update_timestamps_on_up_by_default()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        sleep(1);   // needed to have delay between creation and update

        $model2->up();

        $this->assertNotEquals($model1->created_at, $model1->fresh()->updated_at);
        $this->assertNotEquals($model2->created_at, $model2->fresh()->updated_at);
    }

    /** @test */
    public function not_update_timestamps_on_up_when_config_up()
    {
        $this->setClass(TimestampsDisabledModel::class);

        $model1 = $this->newModel();
        $model2 = $this->newModel();

        sleep(1);   // needed to have delay between creation and update

        $model2->up();

        $this->assertEquals($model1->created_at, $model1->fresh()->updated_at);
        $this->assertEquals($model2->created_at, $model2->fresh()->updated_at);

        $model2->name = "Model #2 - updated";
        $model2->save();
        
        $this->assertNotEquals($model2->created_at, $model2->fresh()->updated_at);
    }
}
