<?php

declare(strict_types=1);

namespace Domains\Payments\Repositories\Eloquent;

use Domains\Payments\Models\Payment;
use Domains\Payments\Repositories\PaymentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

final class PaymentRepository extends \Parents\Repositories\Repository implements PaymentRepositoryInterface
{

    public function basicPaginate(string $search, int $pagination): LengthAwarePaginator
    {
        /** @var LengthAwarePaginator $payments */
        $payments = Payment::search($search)
            ->latest()
            ->paginate(5);
        return $payments;
    }
}
