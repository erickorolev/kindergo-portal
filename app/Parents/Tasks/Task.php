<?php

declare(strict_types=1);

namespace Parents\Tasks;

use Lorisleiva\Actions\Concerns\AsAction;
use Parents\Traits\HasRequestCriteriaTrait;

abstract class Task
{
    use AsAction;
    use HasRequestCriteriaTrait;
}
