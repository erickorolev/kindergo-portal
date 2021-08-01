@php $editing = isset($user) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $user->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            value="{{ old('email', ($editing ? $user->email : '')) }}"
            maxlength="190"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="firstname"
            label="Firstname"
            value="{{ old('firstname', ($editing ? $user->firstname : '')) }}"
            maxlength="190"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="lastname"
            label="Lastname"
            value="{{ old('lastname', ($editing ? $user->lastname : '')) }}"
            maxlength="190"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="middle_name"
            label="Middle Name"
            value="{{ old('middle_name', ($editing ? $user->middle_name : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone"
            label="Phone"
            value="{{ old('phone', ($editing ? $user->phone : '')) }}"
            maxlength="20"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="otherphone"
            label="Otherphone"
            value="{{ old('otherphone', ($editing ? $user->otherphone : '')) }}"
            maxlength="20"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="gender" label="Gender">
            @php $selected = old('gender', ($editing ? $user->gender : 'Other')) @endphp
            <option value="Male" {{ $selected == 'Male' ? 'selected' : '' }} >Male</option>
            <option value="Female" {{ $selected == 'Female' ? 'selected' : '' }} >Female</option>
            <option value="Other" {{ $selected == 'Other' ? 'selected' : '' }} >Other</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="attendant_category" label="Attendant Category">
            @php $selected = old('attendant_category', ($editing ? $user->attendant_category : 'Driver')) @endphp
            <option value="Driver" {{ $selected == 'Driver' ? 'selected' : '' }} >Driver</option>
            <option value="Pedestrian" {{ $selected == 'Pedestrian' ? 'selected' : '' }} >Pedestrian</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="attendant_status" label="Attendant Status">
            @php $selected = old('attendant_status', ($editing ? $user->attendant_status : 'Active')) @endphp
            <option value="Active" {{ $selected == 'Active' ? 'selected' : '' }} >Active</option>
            <option value="Inactive" {{ $selected == 'Inactive' ? 'selected' : '' }} >Inactive</option>
            <option value="Standby" {{ $selected == 'Standby' ? 'selected' : '' }} >Standby</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="attendant_hired"
            label="Attendant Hired"
            value="{{ old('attendant_hired', ($editing ? optional($user->attendant_hired)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="birthday"
            label="Birthday"
            value="{{ old('birthday', ($editing ? optional($user->birthday)->format('Y-m-d') : '')) }}"
            max="255"
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mailingzip"
            label="Mailingzip"
            value="{{ old('mailingzip', ($editing ? $user->mailingzip : '')) }}"
            maxlength="10"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mailingstate"
            label="Mailingstate"
            value="{{ old('mailingstate', ($editing ? $user->mailingstate : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mailingcountry"
            label="Mailingcountry"
            value="{{ old('mailingcountry', ($editing ? $user->mailingcountry : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mailingcity"
            label="Mailingcity"
            value="{{ old('mailingcity', ($editing ? $user->mailingcity : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="mailingstreet"
            label="Mailingstreet"
            value="{{ old('mailingstreet', ($editing ? $user->mailingstreet : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="otherzip"
            label="Otherzip"
            value="{{ old('otherzip', ($editing ? $user->otherzip : '')) }}"
            maxlength="10"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="otherstate"
            label="Otherstate"
            value="{{ old('otherstate', ($editing ? $user->otherstate : '')) }}"
            maxlength="50"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="othercountry"
            label="Othercountry"
            value="{{ old('othercountry', ($editing ? $user->othercountry : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="othercity"
            label="Othercity"
            value="{{ old('othercity', ($editing ? $user->othercity : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="otherstreet"
            label="Otherstreet"
            value="{{ old('otherstreet', ($editing ? $user->otherstreet : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="metro_station"
            label="Metro Station"
            value="{{ old('metro_station', ($editing ? $user->metro_station : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="car_model"
            label="Car Model"
            value="{{ old('car_model', ($editing ? $user->car_model : '')) }}"
            maxlength="100"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="car_year"
            label="Car Year"
            value="{{ old('car_year', ($editing ? $user->car_year : '')) }}"
            maxlength="10"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="car_color"
            label="Car Color"
            value="{{ old('car_color', ($editing ? $user->car_color : '')) }}"
            maxlength="190"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="resume" label="Resume" maxlength="255"
            >{{ old('resume', ($editing ? $user->resume : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="payment_data"
            label="Payment Data"
            maxlength="255"
            >{{ old('payment_data', ($editing ? $user->payment_data : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="crmid"
            label="Crmid"
            value="{{ old('crmid', ($editing ? $user->crmid : '')) }}"
            maxlength="50"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="assigned_user_id"
            label="Assigned User Id"
            value="{{ old('assigned_user_id', ($editing ? $user->assigned_user_id : '19x1')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $user->avatar ? $user->avatar->getUrl() : '' }}')"
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

    <x-inputs.group class="w-full">
        <x-inputs.partials.label
            name="files"
            label="Files"
        ></x-inputs.partials.label
        ><br />

        <input type="file" name="files" id="files" class="form-control-file" />

        @if($editing && $user->files)
        <div class="mt-2">
            <a href="{{ \Storage::url($user->files) }}" target="_blank"
                ><i class="icon ion-md-download"></i>&nbsp;Download</a
            >
        </div>
        @endif @error('files') @include('components.inputs.partials.error')
        @enderror
    </x-inputs.group>

    <div class="px-4 my-4">
        <h4 class="font-bold text-lg text-gray-700">
            Assign @lang('crud.roles.name')
        </h4>

        <div class="py-2">
            @foreach ($roles as $role)
            <div>
                <x-inputs.checkbox
                    id="role{{ $role->id }}"
                    name="roles[]"
                    label="{{ ucfirst($role->name) }}"
                    value="{{ $role->id }}"
                    :checked="isset($user) ? $user->hasRole($role) : false"
                    :add-hidden-value="false"
                ></x-inputs.checkbox>
            </div>
            @endforeach
        </div>
    </div>
</div>
