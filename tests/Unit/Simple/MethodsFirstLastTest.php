<?php

namespace HighSolutions\EloquentSequence\Test\Unit\Simple;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use HighSolutions\EloquentSequence\Test\SequenceTestCase;
use HighSolutions\EloquentSequence\Test\Models\SimpleModel;

class MethodsFirstLastTest extends SequenceTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->setClass(SimpleModel::class);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_first_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model1->isFirst());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_first_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model2->isFirst());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_not_first_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model1->isNotFirst());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_not_first_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model2->isNotFirst());
    }

// LAST

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_last_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model1->isLast());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_last_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model2->isLast());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_not_last_method_on_first_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertTrue($model1->isNotLast());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function use_is_not_last_method_on_second_element()
    {
        $model1 = $this->newModel();
        $model2 = $this->newModel();

        $this->assertFalse($model2->isNotLast());
    }
}
