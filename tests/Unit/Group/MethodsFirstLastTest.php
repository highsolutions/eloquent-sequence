<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Group;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\GroupModel;

class MethodsFirstLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(GroupModel::class);
    }

    /** @test */
    public function use_is_first_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model1->isFirst());
    }

    /** @test */
    public function use_is_first_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model2->isFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model1->isNotFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model2->isNotFirst());
    }

// LAST

    /** @test */
    public function use_is_last_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model1->isLast());
    }

    /** @test */
    public function use_is_last_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model2->isLast());
    }

    /** @test */
    public function use_is_not_last_method_on_first_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model1->isNotLast());
    }

    /** @test */
    public function use_is_not_last_method_on_second_element_with_the_same_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model2->isNotLast());
    }

// DIFFERENT GROUPS

    /** @test */
    public function use_is_first_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);

        $this->assertTrue($model1->isFirst());
    }

    /** @test */
    public function use_is_first_method_on_first_element_of_different_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);

        $this->assertTrue($model2->isFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);

        $this->assertFalse($model1->isNotFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_first_element_of_different_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);

        $this->assertFalse($model2->isNotFirst());
    }

    /** @test */
    public function use_is_first_method_on_third_element_but_second_in_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model3->isFirst());
    }

    /** @test */
    public function use_is_not_first_method_on_third_element_but_second_in_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model3->isNotFirst());
    }

// LAST

    /** @test */
    public function use_is_last_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model1->isLast());
    }

    /** @test */
    public function use_is_last_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model2->isLast());
    }

    /** @test */
    public function use_is_not_last_method_on_first_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model1->isNotLast());
    }

    /** @test */
    public function use_is_not_last_method_on_second_element_with_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model2->isNotLast());
    }

    /** @test */
    public function use_is_last_method_on_third_element_but_second_in_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertTrue($model3->isLast());
    }

    /** @test */
    public function use_is_not_last_method_on_third_element_but_second_in_group()
    {
        $model1 = $this->newModel(['group' => 'A']);
        $model2 = $this->newModel(['group' => 'B']);
        $model3 = $this->newModel(['group' => 'A']);

        $this->assertFalse($model3->isNotLast());
    }

}
