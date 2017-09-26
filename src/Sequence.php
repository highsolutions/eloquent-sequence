<?php 

namespace HighSolutions\EloquentSequence;

use HighSolutions\EloquentSequence\SequenceObserver;
use HighSolutions\EloquentSequence\SequenceService;
use Illuminate\Database\Eloquent\Builder;

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
     * Scope a query to order by sequence attribute
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
     * Refresh all sequence position of model.
     * 
     * @return Model
     */
    public static function refreshSequence()
    {
        return (new SequenceService)->refresh(get_called_class());
    }

}
