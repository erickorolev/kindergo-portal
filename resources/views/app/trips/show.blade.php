<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.trips.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('admin.trips.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.name')
                        </h5>
                        <span>{{ $trip->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.where_address')
                        </h5>
                        <span>{{ $trip->where_address ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.date')
                        </h5>
                        <span>{{ $trip->date ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.time')
                        </h5>
                        <span>{{ $trip->time ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.childrens')
                        </h5>
                        <span>{{ $trip->childrens ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.duration')
                        </h5>
                        <span>{{ $trip->duration ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.distance')
                        </h5>
                        <span>{{ $trip->distance ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.status')
                        </h5>
                        <span>{{ $trip->status ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.scheduled_wait_where')
                        </h5>
                        <span>{{ $trip->scheduled_wait_where ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.scheduled_wait_from')
                        </h5>
                        <span>{{ $trip->scheduled_wait_from ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.not_scheduled_wait_where')
                        </h5>
                        <span
                            >{{ $trip->not_scheduled_wait_where ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.not_scheduled_wait_from')
                        </h5>
                        <span>{{ $trip->not_scheduled_wait_from ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.parking_cost')
                        </h5>
                        <span>{{ $trip->parking_cost ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.attendant_income')
                        </h5>
                        <span>{{ $trip->attendant_income ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.user_id')
                        </h5>
                        <span>{{ optional($trip->user)->name ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.crmid')
                        </h5>
                        <span>{{ $trip->crmid ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.assigned_user_id')
                        </h5>
                        <span>{{ $trip->assigned_user_id ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.trips.inputs.cf_timetable_id')
                        </h5>
                        <span>{{ $trip->cf_timetable_id ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        @foreach($trip->documents as $document)
                            <a href="{{ \Storage::url($document->getUrl()) }}" target="_blank"
                            ><i class="icon ion-md-download"></i>&nbsp;Download</a
                            >
                        @endforeach
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('admin.trips.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create trips')
                    <a href="{{ route('admin.trips.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
