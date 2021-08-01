<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.trips.index_title')
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
                            @can('create trips')
                            <a
                                href="{{ route('admin.trips.create') }}"
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
                                    @lang('crud.trips.inputs.name')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.trips.inputs.where_address')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.trips.inputs.date')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.trips.inputs.time')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.trips.inputs.childrens')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.trips.inputs.duration')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.trips.inputs.distance')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.trips.inputs.status')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.trips.inputs.parking_cost')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.trips.inputs.attendant_income')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($trips as $trip)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->where_address ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->time ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $trip->childrens ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $trip->duration ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $trip->distance ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $trip->status ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $trip->parking_cost ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $trip->attendant_income ?? '-' }}
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
                                        @can('update trips')
                                        <a
                                            href="{{ route('admin.trips.edit', $trip->id) }}"
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
                                        @endcan @can('view trips')
                                        <a
                                            href="{{ route('admin.trips.show', $trip->id) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete trips')
                                        <form
                                            action="{{ route('admin.trips.destroy', $trip->id) }}"
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
                                <td colspan="11">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="11">
                                    <div class="mt-10 px-4">
                                        {!! $trips->render() !!}
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
