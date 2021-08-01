@php $editing = isset($payment) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.date
            name="pay_date"
            label="Pay Date"
            value="{{ old('pay_date', ($editing ? optional($payment->pay_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            value="{{ old('amount', ($editing ? $payment->amount : '')) }}"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="spstatus"
            label="Spstatus"
            value="{{ old('spstatus', ($editing ? $payment->spstatus : 'Scheduled')) }}"
            maxlength="100"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="attendanta_signature"
            label="Attendants Signature"
            value="{{ old('attendants_signature', ($editing ? $payment->attendanta_signature : 'Signed by')) }}"
            maxlength="100"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="dispute_reason"
            label="Dispute Reason"
            maxlength="255"
            >{{ old('dispute_reason', ($editing ? $payment->dispute_reason :
            '')) }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="pay_type" label="Pay Type">
            @php $selected = old('pay_type', ($editing ? $payment->pay_type : '')) @endphp
            <option value="Receipt" {{ $selected == 'Receipt' ? 'selected' : '' }} >Receipt</option>
            <option value="Expense" {{ $selected == 'Expense' ? 'selected' : '' }} >Expense</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $payment->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="assigned_user_id"
            label="Assigned User Id"
            value="{{ old('assigned_user_id', ($editing ? $payment->assigned_user_id : '19x1')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
