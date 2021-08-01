<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Controllers\Api;

use Domains\Payments\Actions\DeletePaymentAction;
use Domains\Payments\Actions\GetAllPaymentsAction;
use Domains\Payments\Actions\GetPaymentByIdAction;
use Domains\Payments\Actions\StorePaymentAction;
use Domains\Payments\Actions\UpdatePaymentAction;
use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Http\Requests\Admin\DeletePaymentRequest;
use Domains\Payments\Http\Requests\Admin\IndexPaymentRequest;
use Domains\Payments\Http\Requests\Admin\ShowPaymentRequest;
use Domains\Payments\Http\Requests\Api\PaymentStoreApiRequest;
use Domains\Payments\Http\Requests\Api\PaymentUpdateApiRequest;
use Domains\Payments\Models\Payment;
use Domains\Payments\Transformers\PaymentTransformer;
use Parents\Controllers\Controller;
use Parents\Serializers\JsonApiSerializer;
use Parents\Traits\RelationTrait;
use Symfony\Component\HttpFoundation\Response;

final class PaymentApiController extends Controller
{
    use RelationTrait;

    protected string $relationClass = GetPaymentByIdAction::class;

    public function index(IndexPaymentRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var Payment[] $payments */
        $payments = GetAllPaymentsAction::run();

        return fractal(
            $payments,
            new PaymentTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Payment::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function store(PaymentStoreApiRequest $request): \Illuminate\Http\JsonResponse
    {
        /** @var Payment $payment */
        $payment = StorePaymentAction::run(PaymentData::fromRequest($request, 'data.attributes.'));

        return fractal(
            $payment,
            new PaymentTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Payment::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_CREATED, [
                'Location' => route('api.payments.show', [
                    'payment' => $payment->id
                ])
            ]);
    }

    public function show(ShowPaymentRequest $request, int $payment): \Illuminate\Http\JsonResponse
    {
        return fractal(
            GetPaymentByIdAction::run($payment),
            new PaymentTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Payment::RESOURCE_NAME)
            ->respondJsonApi();
    }

    public function update(PaymentUpdateApiRequest $request, int $payment): \Illuminate\Http\JsonResponse
    {
        $paymentData = PaymentData::fromRequest($request, 'data.attributes.');
        $paymentData->id = $payment;

        return fractal(
            UpdatePaymentAction::run($paymentData),
            new PaymentTransformer(),
            new JsonApiSerializer($this->getUrl())
        )->withResourceName(Payment::RESOURCE_NAME)
            ->respondJsonApi(Response::HTTP_ACCEPTED);
    }

    public function destroy(DeletePaymentRequest $request, int $payment): \Illuminate\Http\Response
    {
        DeletePaymentAction::run($payment);

        return response()->noContent();
    }
}
