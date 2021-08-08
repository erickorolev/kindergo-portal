<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Controllers\Api;

use Domains\Payments\Actions\ReceivePaymentFromCrmAction;
use Domains\Payments\Models\Payment;
use Domains\Payments\Transformers\PaymentTransformer;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;

final class ForcePaymentReceiveController extends Controller
{
    public function __invoke(int $id): \Illuminate\Http\JsonResponse
    {
        return fractal(
            ReceivePaymentFromCrmAction::run($id),
            new PaymentTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Payment::RESOURCE_NAME)
            ->respondJsonApi();
    }
}
