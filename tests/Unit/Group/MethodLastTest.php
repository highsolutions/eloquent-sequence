<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class MethodLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function use_last_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_last_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_3_elements_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(3, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_last_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $model2->moveToLast();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }

    /** @test */
    public function use_last_method_on_first_element_with_3_elements_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $model1->moveToLast();

        $this->assertEquals(3, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
        $this->assertEquals(2, $model3->fresh()->seq);
    }
}
