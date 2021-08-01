<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.payments.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create payments')
                            <a
                                href="{{ route('admin.payments.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.pay_date')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.payments.inputs.amount')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.spstatus')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.attendants_signature')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.dispute_reason')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.pay_type')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.user_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.payments.inputs.assigned_user_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->pay_date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $payment->amount->getFormattedValue() ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->spstatus->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->attendanta_signature->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->dispute_reason ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->pay_type ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($payment->user)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $payment->assigned_user_id ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="relative inline-flex align-middle"
                                    >
                                        @can('update payments', $payment->id)
                                        <a
                                            href="{{ route('admin.payments.edit', $payment->id) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view payments')
                                        <a
                                            href="{{ route('admin.payments.show', $payment->id) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete payments', $payment->id)
                                        <form
                                            action="{{ route('admin.payments.destroy', $payment->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-trash text-red-600"
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <div class="mt-10 px-4">
                                        {!! $payments->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
