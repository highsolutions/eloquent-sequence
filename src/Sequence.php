<?php

namespace HighSolutions\EloquentSequence;

trait Sequence
{
    /**
     * Return the sequence configuration array for this model.
     *
     * @return array
     */
    abstract public function sequence();

    /**
     * Boot Sequence Observer for event handling.
     *
     * @return void
     */
    public static function bootSequence()
    {
        self::observe(SequenceObserver::class);
    }

    /**
     * Scope a query to order by sequence attribute.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $direction Sorting order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSequenced($query, $direction = 'asc')
    {
        $fieldName = isset($this->sequence()['fieldName']) ? $this->sequence()['fieldName'] : 'seq';

        return $query->orderBy($fieldName, $direction);
    }

    /**
     * Move object one position earlier.
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function up()
    {
        return (new SequenceService)->moveUp($this);
    }

    /**
     * Move object one position later.
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function down()
    {
        return (new SequenceService)->moveDown($this);
    }

    /**
     * Move object to another position.
     *
     * @return Model
     * @param int $position
     * @throws ModelNotFoundException
     */
    public function move($position)
    {
        return (new SequenceService)->moveTo($this, $position);
    }

    /**
     * Move object to the first position.
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function moveToFirst()
    {
        return (new SequenceService)->moveTo($this, 0);
    }

    /**
     * Move object to the last position.
     *
     * @return Model
     * @throws ModelNotFoundException
     */
    public function moveToLast()
    {
        return (new SequenceService)->moveTo($this, $this->count());
    }

    /**
     * Refresh all sequence position of model.
     *
     * @return Model
     */
    public static function refreshSequence()
    {
        return (new SequenceService)->refresh(get_called_class());
    }
}
