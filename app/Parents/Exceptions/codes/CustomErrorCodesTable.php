<?php

namespace Parents\Exceptions\codes;

class CustomErrorCodesTable extends ErrorCodesTable
{
    /**
     * Use this class to define your own custom error code tables. Please follow the scheme defined in the other file
     * in order to make them compliant!
     *
     * Please note that Realty reserves the error codes 000000 - 099999 for itself. If you define your own codes,
     * please start with 100000
     *
     * const BASE_GENERAL_ERROR = [
     *      'code' => 100000,
     *      'title' => 'Unknown / Unspecified Error.',
     *      'description' => 'Something unexpected happened.',
     *  ];
     *
     */
}
