@php $editing = isset($child) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="firstname"
            label="Firstname"
            value="{{ old('firstname', ($editing ? $child->firstname : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="lastname"
            label="Lastname"
            value="{{ old('lastname', ($editing ? $child->lastname : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="middle_name"
            label="Middle Name"
            value="{{ old('middle_name', ($editing ? $child->middle_name : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="birthday"
            label="Birthday"
            value="{{ old('birthday', ($editing ? optional($child->birthday)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="gender" label="Gender">
            @php $selected = old('gender', ($editing ? $child->gender->value : '')) @endphp
            <option value="Male" {{ $selected == 'Male' ? 'selected' : '' }} >Male</option>
            <option value="Female" {{ $selected == 'Female' ? 'selected' : '' }} >Female</option>
            <option value="Other" {{ $selected == 'Other' ? 'selected' : '' }} >Other</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            value="{{ old('phone', ($editing ? $child->phone : '')) }}"
            maxlength="20"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="otherphone"
            label="Otherphone"
            value="{{ old('otherphone', ($editing ? $child->otherphone : '')) }}"
            maxlength="20"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="crmid"
            label="Crmid"
            value="{{ old('crmid', ($editing ? $child->crmid : '')) }}"
            maxlength="50"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="assigned_user_id"
            label="Assigned User Id"
            value="{{ old('assigned_user_id', ($editing ? $child->assigned_user_id : '19x1')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $child->avatar ? $child->avatar->getUrl() : '' }}')"
        >
            <x-inputs.partials.label
                name="imagename"
                label="Imagename"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="imagename"
                    id="imagename"
                    @change="fileChosen"
                />
            </div>

            @error('imagename') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>
</div>
