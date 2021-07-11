<?php

declare(strict_types=1);

namespace Parents\Traits;

trait StateKeeperTrait
{

    /**
     * Stores Data of any kind during the request life cycle.
     * This helps related Actions can share data from different steps.
     *
     * @var  array
     */
    public array $stateKeeperStates = [];

    /**
     * @param array $data
     *
     * @return  self
     */
    public function keep(array $data = []): self
    {
        /**
         * @var string|int $key
         * @var string $value
         */
        foreach ($data as $key => $value) {
            $this->stateKeeperStates[$key] = $value;
        }

        return $this;
    }

    /**
     * @param string|integer $key
     *
     * @return  mixed
     */
    public function retrieve(string | int $key): mixed
    {
        return $this->stateKeeperStates[$key];
    }
}
