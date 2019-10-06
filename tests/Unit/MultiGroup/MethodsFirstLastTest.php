<?php

namespace HighSolutions\EloquentSequence\Test\Unit\MultiGroup;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\MultiGroupModel;

class MethodsFirstLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(MultiGroupModel::class);
    }

    /** @test */
    public function all_the_same_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $this->assertTrue($model1->isFirst());
        $this->assertFalse($model1->isNotFirst());
        $this->assertFalse($model1->isLast());
        $this->assertTrue($model1->isNotLast());

        $this->assertFalse($model2->isFirst());
        $this->assertTrue($model2->isNotFirst());
        $this->assertFalse($model2->isLast());
        $this->assertTrue($model2->isNotLast());

        $this->assertFalse($model3->isFirst());
        $this->assertTrue($model3->isNotFirst());
        $this->assertTrue($model3->isLast());
        $this->assertFalse($model3->isNotLast());
    }

    /** @test */
    public function one_different_group()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'B']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'A']);

        $this->assertTrue($model1->isFirst());
        $this->assertFalse($model1->isNotFirst());
        $this->assertFalse($model1->isLast());
        $this->assertTrue($model1->isNotLast());

        $this->assertTrue($model2->isFirst());
        $this->assertFalse($model2->isNotFirst());
        $this->assertTrue($model2->isLast());
        $this->assertFalse($model2->isNotLast());

        $this->assertFalse($model3->isFirst());
        $this->assertTrue($model3->isNotFirst());
        $this->assertTrue($model3->isLast());
        $this->assertFalse($model3->isNotLast());
    }

    /** @test */
    public function all_different_groups()
    {
        $model1 = $this->newModel(['group' => 'A', 'group2' => 'A']);
        $model2 = $this->newModel(['group' => 'A', 'group2' => 'B']);
        $model3 = $this->newModel(['group' => 'A', 'group2' => 'C']);

        $this->assertTrue($model1->isFirst());
        $this->assertFalse($model1->isNotFirst());
        $this->assertTrue($model1->isLast());
        $this->assertFalse($model1->isNotLast());

        $this->assertTrue($model2->isFirst());
        $this->assertFalse($model2->isNotFirst());
        $this->assertTrue($model2->isLast());
        $this->assertFalse($model2->isNotLast());

        $this->assertTrue($model3->isFirst());
        $this->assertFalse($model3->isNotFirst());
        $this->assertTrue($model3->isLast());
        $this->assertFalse($model3->isNotLast());
    }
}
