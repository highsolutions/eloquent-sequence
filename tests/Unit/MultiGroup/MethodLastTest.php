<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class MethodLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    /** @test */
    public function use_last_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_last_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_3_elements_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(3, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_wrong_sequence_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 2]);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 4]);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 5]);

        $model1->moveToLast();

        $this->assertEquals(5, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(4, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_last_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_3_elements_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $this->create(1, ['group' => 'B', 'group2' => 'A']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(3, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_wrong_sequence_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 2]);
        $modelb1 = $this->newModel(['group' => 'B', 'group2' => 'A', 'seq' => 1]);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 6]);
        $modelb2 = $this->newModel(['group' => 'B', 'group2' => 'A', 'seq' => 3]);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A', 'seq' => 9]);

        $model1->moveToLast();
        $modelb1->moveToLast();

        $this->assertEquals(9, $model1->fresh()->seq);
        $this->assertEquals(5, $model2->fresh()->seq);
        $this->assertEquals(8, $model3->fresh()->seq);
        $this->assertEquals(3, $modelb1->fresh()->seq);
        $this->assertEquals(2, $modelb2->fresh()->seq);
    }
}
