<?php

namespace Parents\Factories;

abstract class Factory extends \Illuminate\Database\Eloquent\Factories\Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    abstract public function definition(): array;
}
