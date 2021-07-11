<?php

declare(strict_types=1);

namespace Parents\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as LaravelBaseController;
use Parents\Traits\HashIdTrait;
use Psalm\Type\Atomic\CallableTrait;

abstract class Controller extends LaravelBaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    use HashIdTrait;
    use CallableTrait;
}
