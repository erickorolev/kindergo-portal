<?php

declare(strict_types=1);

namespace Domains\Children\Jobs;

use Domains\Attendants\Models\Attendant;
use Domains\Attendants\Services\AttendantConnector;
use Domains\Children\Models\Child;
use Domains\Children\Services\ChildConnector;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

final class SendChildToVtigerJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public Child $child
    ) {
    }

    public function handle(): void
    {
        return;
        $connector = app(ChildConnector::class);

        try {
            $connector->send($this->child);
        } catch (\DomainException | \InvalidArgumentException $e) {
            Log::error('Validation Error in updating child in Vtiger: ' . $e->getMessage());
            app('sentry')->captureException($e);
        }
    }
}
