<?php

namespace HighSolutions\EloquentSequence;

use Psr\Log\InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SequenceService
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $obj;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param \Illuminate\Database\Eloquent\Model $obj
     * @return $this
     */
    public function setModel(Model $obj)
    {
        $this->obj = $obj;
        $this->pullConfigurationFromModel();

        return $this;
    }

    /**
     * Assign configuration of stored Model object to $this->config.
     *
     * @return void
     */
    protected function pullConfigurationFromModel()
    {
        $this->config = $this->getDefaultConfiguration();

        foreach ($this->obj->sequence() as $key => $value) {
            $this->config[$key] = $value;
        }
    }

    /**
     * Returns default configuration of service.
     *
     * @return array
     */
    protected function getDefaultConfiguration()
    {
        return [
            'group' => '',
            'fieldName' => 'seq',
            'exceptions' => false,
            'orderFrom1' => false,
        ];
    }

    /**
     * Assign sequence attribute to model.
     *
     * @param \Illuminate\Database\Eloquent\Model $obj
     * @return void
     */
    public function assignSequence(Model $obj)
    {
        $this->setModel($obj);

        if ($this->isAlreadyAssigned() == true) {
            return;
        }

        $query = $this->prepareQuery();
        $this->calculateSequenceForObject($query);
    }

    /**
     * Check if sequence attribute is already assigned. If yes, terminate operation.
     *
     * @return bool
     */
    protected function isAlreadyAssigned()
    {
        return $this->obj->{$this->getSequenceConfig('fieldName')} != 0;
    }

    /**
     * Get value from configuration of given key.
     *
     * @param string $key
     * @return mixed
     */
    protected function getSequenceConfig($key, $fireException = true)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }

        if ($fireException) {
            throw new InvalidArgumentException("There is no specific key ({$key}) in Sequence configuration.");
        }

        return null;
    }

    /**
     * Check if group configuration is set.
     *
     * @return bool
     */
    protected function isGroupProvided()
    {
        $group = $this->getSequenceConfig('group');

        return $group !== null && $group !== '';
    }

    /**
     * Prepares query based on group configuration.
     *
     * @return Model
     */
    protected function prepareQuery()
    {
        $query = $this->obj->newQuery();

        return $this->fillQueryWithGroupConditions($query);
    }

    /**
     * Fills query with where clauses for specified group configuration.
     *
     * @param \Illuminate\Database\Eloquent\Model $query
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function fillQueryWithGroupConditions($query)
    {
        if ($this->isGroupProvided() == true) {
            $groups = $this->getSequenceConfig('group');
            if (is_array($groups) == false) {
                $groups = [$groups];
            }

            foreach ($groups as $group) {
                $query = $query->where($group, $this->obj->{$group});
            }
        }

        return $query;
    }

    /**
     * Assign calculated sequence value to given object.
     *
     * @param \Illuminate\Database\Eloquent\Model
     * @return void
     */
    protected function calculateSequenceForObject($query)
    {
        $this->obj->{$this->getSequenceConfig('fieldName')} = $query->max($this->getSequenceConfig('fieldName')) + 1;
    }

    /**
     * Update sequence attribute to models when deleted or group changed.
     *
     * @param \Illuminate\Database\Eloquent\Model $obj
     * @return void
     */
    public function updateSequences()
    {
        $query = $this->prepareQueryWithObjectsNeedingUpdate();
        $query = $this->fillQueryWithGroupConditions($query);
        $this->decrementObjects($query);
    }

    /**
     * Update sequence attribute to models with sequence number greater than deleted object.
     *
     * @param \Illuminate\Database\Eloquent\Model $obj
     * @return void
     */
    public function updateSequencesonDelete(Model $obj)
    {
        $this->setModel($obj);

        if ($this->getSequenceConfig('notUpdateOnDelete', false)) {
            return;
        }

        $this->updateSequences();
    }

    /**
     * Prepares query with objects stored in database with sequence number greater than deleteting object.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function prepareQueryWithObjectsNeedingUpdate()
    {
        return $this->obj->newQuery()
            ->where($this->getSequenceConfig('fieldName'), '>', $this->obj->{$this->getSequenceConfig('fieldName')});
    }

    /**
     * Execute query with decrementing sequence attribute for objects that fulfills conditions.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return void
     */
    protected function decrementObjects($query)
    {
        $disableTimestamps = $this->getSequenceConfig('disableTimestamps', false);

        $timestamps = $this->obj->timestamps;
        if ($disableTimestamps) $this->obj->timestamps = false;

        $query->decrement($this->getSequenceConfig('fieldName'));

        $this->obj->timestamps = $timestamps;
    }

    /**
     * Move object one position earlier.
     *
     * @param Model $obj
     * @return Model
     */
    public function moveUp(Model $obj)
    {
        $this->setModel($obj);

        return $this->moveObject($this->getPreviousObject());
    }

    /**
     * Move ojbect one position lower.
     *
     * @param Model $obj
     * @return Model
     */
    public function moveDown(Model $obj)
    {
        $this->setModel($obj);

        return $this->moveObject($this->getNextObject());
    }

    /**
     * Swap position between two objects.
     *
     * @param Model|null $secondObj
     * @return Model
     * @throws ModelNotFoundException
     */
    private function moveObject($secondObj = null)
    {
        if ($secondObj == null) {
            if ($this->getSequenceConfig('exceptions')) {
                throw new ModelNotFoundException();
            }

            return $this->obj;
        }

        $currentSequence = $this->getSequence($this->obj);
        $this->setSequence($this->obj, $this->getSequence($secondObj));
        $this->setSequence($secondObj, $currentSequence);

        return $this->obj;
    }

    /**
     * Returns position of object.
     *
     * @param Model $obj
     * @return Model
     */
    private function getSequence($obj)
    {
        return $obj->{$this->getSequenceConfig('fieldName')};
    }

    /**
     * Sets position of object with value.
     *
     * @param Model $obj
     * @param int $value
     * @return void
     */
    private function setSequence(&$obj, $value)
    {
        $obj->{$this->getSequenceConfig('fieldName')} = $value;
        $disableTimestamps = $this->getSequenceConfig('disableTimestamps', false);

        $timestamps = $obj->timestamps;
        if ($disableTimestamps) $obj->timestamps = false;

        $obj->save();

        $obj->timestamps = $timestamps;
    }

    /**
     * Returns object one position earlier than base one.
     *
     * @return Model
     */
    private function getPreviousObject()
    {
        return $this->getNearObject(true);
    }

    /**
     * Returns object one position later than base one.
     *
     * @return Model
     */
    private function getNextObject()
    {
        return $this->getNearObject(false);
    }

    /**
     * Returns object one position earlier/later than base one.
     *
     * @param bool $earlier
     * @return Model
     */
    private function getNearObject($earlier)
    {
        $currentSequence = $this->getSequence($this->obj);
        $query = $this->prepareQuery();
        $condition = $earlier ? '<' : '>';

        return $query->where($this->getSequenceConfig('fieldName'), $condition, $currentSequence)
            ->sequenced($earlier ? 'desc' : 'asc')
            ->first();
    }

    /**
     * Move object to another positon.
     *
     * @param Model $obj
     * @param int $position
     * @return Model
     */
    public function moveTo(Model $obj, $position)
    {
        $this->setModel($obj);
        if (! $this->getSequenceConfig('orderFrom1')) {
            $position++;
        }

        $currentSequence = $this->getSequence($this->obj);
        if ($currentSequence == $position) {
            return $obj;
        }

        if ($currentSequence < $position) {
            return $this->moveFurther($position);
        }

        return $this->moveEarlier($position);
    }

    public function moveToLast(Model $obj)
    {
        $this->setModel($obj);
        $query = $this->prepareQuery();
        $query = $this->fillQueryWithGroupConditions($query);

        return $this->moveTo($obj, $query->max($this->getSequenceConfig('fieldName')));
    }

    protected function moveFurther($position)
    {
        $max = $this->count();
        if ($this->getSequenceConfig('exceptions') && $max < $position) {
            throw new InvalidArgumentException('The parameter is out of range.');
        }

        $query = $this->prepareQuery();
        $currentSequence = $this->getSequence($this->obj);
        $disableTimestamps = $this->getSequenceConfig('disableTimestamps', false);

        $timestamps = $this->obj->timestamps;
        if ($disableTimestamps) $this->obj->timestamps = false;

        $query->where($this->getSequenceConfig('fieldName'), '>', $currentSequence)
            ->where($this->getSequenceConfig('fieldName'), '<=', $position)
            ->sequenced()
            ->decrement($this->getSequenceConfig('fieldName'));

        $this->setSequence($this->obj, $position <= $max ? $position : $max);

        $this->obj->timestamps = $timestamps;

        return $this->obj;
    }

    protected function count()
    {
        return $this->prepareQuery()
            ->sequenced('desc')
            ->first()
            ->{$this->getSequenceConfig('fieldName')};
    }

    protected function moveEarlier($position)
    {
        if ($this->getSequenceConfig('exceptions') && $position < ($this->getSequenceConfig('orderFrom1') ? 2 : 1)) {
            throw new InvalidArgumentException('The parameter is out of range.');
        }

        $query = $this->prepareQuery();
        $currentSequence = $this->getSequence($this->obj);
        $disableTimestamps = $this->getSequenceConfig('disableTimestamps', false);

        $timestamps = $this->obj->timestamps;
        if ($disableTimestamps) $this->obj->timestamps = false;

        $query->where($this->getSequenceConfig('fieldName'), '>=', $position)
            ->where($this->getSequenceConfig('fieldName'), '<', $currentSequence)
            ->sequenced()
            ->increment($this->getSequenceConfig('fieldName'));

        $this->setSequence($this->obj, $position < 1 ? 1 : $position);

        $this->obj->timestamps = $timestamps;

        return $this->obj;
    }

    public function refresh($class)
    {
        $this->setModel(resolve($class));

        $sequences = [];
        $field = $this->getSequenceConfig('fieldName');
        $disableTimestamps = $this->getSequenceConfig('disableTimestamps', false);

        $results = $this->obj->newQuery()
            ->sequenced()
            ->get()
            ->each(function ($item) use ($field, &$sequences, $disableTimestamps) {
                $key = $this->generateConditionsHash($item);
                if (! isset($sequences[$key])) {
                    $sequences[$key] = 1;
                }

                $item->{$field} = $sequences[$key]++;

                $timestamps = $item->timestamps;
                if ($disableTimestamps) $item->timestamps = false;

                $item->save();

                $item->timestamps = $timestamps;
            });

        return $this->obj;
    }

    protected function generateConditionsHash($item)
    {
        $key = '';
        if ($this->isGroupProvided() == true) {
            $groups = $this->getSequenceConfig('group');
            if (is_array($groups) == false) {
                $groups = [$groups];
            }

            foreach ($groups as $group) {
                $key .= $item->{$group}.'###';
            }

            return $key;
        }

        return '*'; // all keys
    }

    /**
     * Update sequence attribute to models with sequence number greater than moved out object.
     * Assign sequence attribute to model in new group.
     *
     * @param \Illuminate\Database\Eloquent\Model $obj
     * @return void
     */
    public function updateSequencesOnGroupChange(Model $obj)
    {
        $this->setModel($obj);

        if ($this->isGroupProvided() == false) {
            return;
        }

        $groups = $this->getSequenceConfig('group');
        if (is_array($groups) == false) {
            $groups = [$groups];
        }

        if (! $obj->isDirty($groups)) {
            return;
        }

        $newGroups = [];
        $getOriginalMethod = method_exists($this->obj, 'getRawOriginal') ? 'getRawOriginal' : 'getOriginal';
        foreach ($groups as $group) {
            $newGroups[$group] = $this->obj->{$group};
            $this->obj->{$group} = $this->obj->{$getOriginalMethod}($group);
        }

        $this->updateSequences();

        foreach ($groups as $group) {
            $this->obj->{$group} = $newGroups[$group];
        }

        $obj->{$this->getSequenceConfig('fieldName')} = 0;
        $this->assignSequence($obj);
    }

    /**
     * Check if object is first in sequence.
     *
     * @param Model $obj
     * @return Model
     */
    public function isFirst(Model $obj)
    {
        $this->setModel($obj);

        return $this->getSequence($this->obj) == 1;
    }

    /**
     * Check if object is last in sequence.
     *
     * @param Model $obj
     * @return Model
     */
    public function isLast(Model $obj)
    {
        $this->setModel($obj);

        if ($this->getNearObject(false)) {
            return false;
        }

        return true;
    }
}
