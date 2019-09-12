<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use HighSolutions\EloquentSequence\Test\Models\NotUpdateModel;
use HighSolutions\EloquentSequence\Test\Models\TimestampsDisabledModel;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;

class UpdatingSequenceAfterDeletingObjectsTest extends SequenceTestCase
{
    /** @test */
    public function sets_1_to_second_object_when_first_is_deleted()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertEquals(2, $model2->seq);

        $model1->delete();

        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function sets_2_to_third_object_when_second_is_deleted()
    {
        $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $this->assertEquals(3, $model3->seq);

        $model2->delete();

        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function sets_sequence_lower_to_elements_after_deleted_object()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $model1->delete();

        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function not_update_next_objects_after_deleting_when_config_up()
    {
        $this->setClass(NotUpdateModel::class);

        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        $model1->delete();

        $this->assertEquals(2, $model2->fresh()->seq);
        $this->assertEquals(3, $model3->fresh()->seq);
    }

    /** @test */
    public function update_timestamps_of_next_objects_after_deleting_by_default()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        sleep(1);   // needed to have delay between creation and update

        $model1->delete();

        $this->assertNotEquals($model2->created_at, $model2->fresh()->updated_at);
        $this->assertNotEquals($model3->created_at, $model3->fresh()->updated_at);
    }

    /** @test */
    public function not_update_timestamps_of_next_objects_after_deleting_when_config_up()
    {
        $this->setClass(TimestampsDisabledModel::class);

        $model1 = $this->newModel();
        $model2 = $this->newModel();
        $model3 = $this->newModel();

        sleep(1);   // needed to have delay between creation and update

        $model1->delete();

        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
        $this->assertEquals($model2->created_at, $model2->fresh()->updated_at);
        $this->assertEquals($model3->created_at, $model3->fresh()->updated_at);
    }
}
