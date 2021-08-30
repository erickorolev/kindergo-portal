@php $editing = isset($trip) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $trip->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="where_address"
            label="Where Address"
            value="{{ old('where_address', ($editing ? $trip->where_address : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="date"
            label="Date"
            value="{{ old('date', ($editing ? optional($trip->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="time"
            label="Time"
            value="{{ old('time', ($editing ? $trip->time : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="childrens"
            label="Childrens"
            value="{{ old('childrens', ($editing ? $trip->childrens : '0')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="duration"
            label="Duration"
            value="{{ old('duration', ($editing ? $trip->duration : '0')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="distance"
            label="Distance"
            value="{{ old('distance', ($editing ? $trip->distance : '')) }}"
            max="255"
            step="0.01"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="status"
            label="Status"
            value="{{ old('status', ($editing ? $trip->status : 'Appointed')) }}"
            maxlength="190"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="scheduled_wait_where"
            label="Scheduled Wait Where"
            value="{{ old('scheduled_wait_where', ($editing ? $trip->scheduled_wait_where : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="scheduled_wait_from"
            label="Scheduled Wait From"
            value="{{ old('scheduled_wait_from', ($editing ? $trip->scheduled_wait_from : '')) }}"
            max="255"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="not_scheduled_wait_where"
            label="Not Scheduled Wait Where"
            value="{{ old('not_scheduled_wait_where', ($editing ? $trip->not_scheduled_wait_where : '')) }}"
            max="255"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="not_scheduled_wait_from"
            label="Not Scheduled Wait From"
            value="{{ old('not_scheduled_wait_from', ($editing ? $trip->not_scheduled_wait_from : '')) }}"
            max="255"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="parking_cost"
            label="Parking Cost"
            value="{{ old('parking_cost', ($editing ? $trip->parking_cost : '')) }}"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="attendant_income"
            label="Attendant Income"
            value="{{ old('attendant_income', ($editing ? $trip->attendant_income : '')) }}"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="description" label="Description" maxlength="255"
        >{{ old('description', ($editing ? $trip->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="parking_info" label="Parking Info" maxlength="255"
        >{{ old('parking_info', ($editing ? $trip->parking_info : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $trip->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="crmid"
            label="Crmid"
            value="{{ old('crmid', ($editing ? $trip->crmid : '')) }}"
            maxlength="50"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="assigned_user_id"
            label="Assigned User Id"
            value="{{ old('assigned_user_id', ($editing ? $trip->assigned_user_id : '19x1')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="cf_timetable_id"
            label="Cf Timetable Id"
            value="{{ old('cf_timetable_id', ($editing ? $trip->cf_timetable_id : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.partials.label
            name="document[]"
            label="Document"
        ></x-inputs.partials.label
        ><br />

        <input
            type="file"
            name="document[]"
            id="document"
            class="form-control-file"
            multiple
        />

        @if($editing && $trip->documents)
        <div class="mt-2">
            @foreach($trip->documents as $document)
                <a href="{{ \Storage::url($document->getUrl()) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
                >
            @endforeach
        </div>
        @endif @error('document') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>
</div>
