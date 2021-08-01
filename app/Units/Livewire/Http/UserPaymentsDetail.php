<?php

namespace Units\Livewire\Http;

use Domains\Payments\Models\Payment;
use Domains\Users\Models\User;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserPaymentsDetail extends Component
{
    use AuthorizesRequests;

    public User $user;
    public Payment $payment;
    public null|string $paymentPayDate;

    public array $selected = [];
    public bool $editing = false;
    public bool $allSelected = false;
    public bool $showingModal = false;

    public string $modalTitle = 'New Payment';

    protected array $rules = [
        'paymentPayDate' => ['required', 'date'],
        'payment.type_payment' => [
            'required',
            'in:online payment,bank payment',
        ],
        'payment.amount' => ['required', 'max:255'],
        'payment.spstatus' => [
            'required',
            'in:scheduled,canceled,delayed,executed',
        ],
    ];

    public function mount(User $user): void
    {
        $this->user = $user;
        $this->resetPaymentData();
    }

    public function resetPaymentData(): void
    {
        $this->payment = new Payment();

        $this->paymentPayDate = null;

        $this->dispatchBrowserEvent('refresh');
    }

    public function newPayment(): void
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.user_payments.new_title');
        $this->resetPaymentData();

        $this->showModal();
    }

    public function editPayment(Payment $payment): void
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.user_payments.edit_title');
        $this->payment = $payment;

        $this->paymentPayDate = $this->payment->pay_date->format('Y-m-d');

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal(): void
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal(): void
    {
        $this->showingModal = false;
    }

    public function save(): void
    {
        $this->validate();

        if (!$this->payment->user_id) {
            $this->authorize('create', Payment::class);

            $this->payment->user_id = $this->user->id;
        } else {
            $this->authorize('update', $this->payment);
        }

        $this->payment->pay_date = Carbon::parse($this->paymentPayDate);

        $this->payment->save();

        $this->hideModal();
    }

    public function destroySelected(): void
    {
        $this->authorize('delete-any', Payment::class);

        Payment::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetPaymentData();
    }

    /**
     * @return void
     */
    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->user->payments as $payment) {
            array_push($this->selected, $payment->id);
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('livewire.user-payments-detail', [
            'payments' => $this->user->payments()->paginate(20),
        ]);
    }
}
