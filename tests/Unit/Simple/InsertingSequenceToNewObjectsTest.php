<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;

class InsertingSequenceToNewObjectsTest extends SequenceTestCase
{
    /** @test */
    public function adds_1_to_first_element()
    {
        $model = $this->newModel();

        $this->assertEquals(1, $model->seq);
    }

    /** @test */
    public function adds_2_to_second_element()
    {
        $this->newModel();
        $model = $this->newModel();

        $this->assertEquals(2, $model->seq);
    }

    /** @test */
    public function adds_3_to_third_element()
    {
        $this->create(2);
        $model = $this->newModel();

        $this->assertEquals(3, $model->seq);
    }
}
