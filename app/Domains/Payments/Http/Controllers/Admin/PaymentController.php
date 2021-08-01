<?php

declare(strict_types=1);

namespace Domains\Payments\Http\Controllers\Admin;

use Domains\Payments\Actions\GetAllPaymentsAdminAction;
use Domains\Payments\Actions\GetPaymentByIdAction;
use Domains\Payments\Actions\StorePaymentAction;
use Domains\Payments\Actions\UpdatePaymentAction;
use Domains\Payments\DataTransferObjects\PaymentData;
use Domains\Payments\Http\Requests\Admin\CreatePaymentRequest;
use Domains\Payments\Http\Requests\Admin\DeletePaymentRequest;
use Domains\Payments\Http\Requests\Admin\EditPaymentRequest;
use Domains\Payments\Http\Requests\Admin\IndexPaymentRequest;
use Domains\Payments\Http\Requests\Admin\PaymentStoreRequest;
use Domains\Payments\Http\Requests\Admin\PaymentUpdateRequest;
use Domains\Payments\Http\Requests\Admin\ShowPaymentRequest;
use Domains\Payments\Models\Payment;
use Domains\Users\Actions\GetUsersDropdownListAction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Parents\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

final class PaymentController extends Controller
{
    public function index(IndexPaymentRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var ?string $search */
        $search = $request->get('search', '');

        if (!$search) {
            $search = '';
        }
        /** @var LengthAwarePaginator $payments */
        $payments = GetAllPaymentsAdminAction::run($search);

        return view('app.payments.index', compact('payments', 'search'));
    }

    public function create(CreatePaymentRequest $request): \Illuminate\View\View|View|Application
    {
        /** @var Collection $users */
        $users = GetUsersDropdownListAction::run();

        return view('app.payments.create', compact('users'));
    }

    public function store(
        PaymentStoreRequest $request
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $payment = StorePaymentAction::run(PaymentData::fromRequest($request));

        return redirect()
            ->route('admin.payments.edit', $payment->id)
            ->withSuccess(__('crud.common.created'));
    }

    public function show(ShowPaymentRequest $request, int $payment): \Illuminate\View\View|View|Application
    {

        return view('app.payments.show', [
            'payment' => GetPaymentByIdAction::run($payment)
        ]);
    }

    public function edit(EditPaymentRequest $request, int $payment): \Illuminate\View\View|View|Application
    {
        return view('app.payments.edit', [
            'payment' => GetPaymentByIdAction::run($payment),
            'users' => GetUsersDropdownListAction::run()
        ]);
    }

    public function update(
        PaymentUpdateRequest $request,
        int $payment
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $paymentData = PaymentData::fromRequest($request);
        $paymentData->id = $payment;
        $paymentModel = UpdatePaymentAction::run($paymentData);
        return redirect()
            ->route('admin.payments.edit', $payment)
            ->withSuccess(__('crud.common.saved'));
    }

    public function destroy(
        DeletePaymentRequest $request,
        Payment $payment
    ): \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse {
        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
