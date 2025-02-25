<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class MethodFirstTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $model1->moveToFirst();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $model2->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_third_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);
        $model3 = $this->newModel(['group' => 'A']);

        $model3->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(1, $model3->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);

        $model1->moveToFirst();

        $this->assertEquals(1, $model1->fresh()->seq);
        $this->assertEquals(2, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);

        $model2->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(1, $model2->fresh()->seq);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_first_method_on_third_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model2 = $this->newModel(['group' => 'A']);
        $this->create(1, ['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $model3->moveToFirst();

        $this->assertEquals(2, $model1->fresh()->seq);
        $this->assertEquals(3, $model2->fresh()->seq);
        $this->assertEquals(1, $model3->fresh()->seq);
    }
}
