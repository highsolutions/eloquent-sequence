<?php

namespace HighSolutions\EloquentSequence;

use Illuminate\Database\Eloquent\Model;

class SequenceObserver
{
    /**
     * @var \App\Packages\UpAndDown\SequnceService
     */
    protected $service;

    /**
     * SequenceObserver constructor.
     *
     * @param \App\Packages\UpAndDown\SequnceService $service
     */
    public function __construct(SequenceService $service)
    {
        $this->service = $service;
    }

    /**
     * Listen to the Sequence creating event.
     *
     * @param Model $obj
     * @return void
     */
    public function creating(Model $obj)
    {
        $this->service->assignSequence($obj);
    }

    /**
     * Listen to the Sequence updating event.
     *
     * @param Model $obj
     * @return void
     */
    public function updating(Model $obj)
    {
        $this->service->updateSequencesOnGroupChange($obj);
    }

    /**
     * Listen to the Sequence deleting event.
     *
     * @param Model $obj
     * @return void
     */
    public function deleting(Model $obj)
    {
        $this->service->updateSequencesOnDelete($obj);
    }
}
