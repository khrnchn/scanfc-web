@php $editing = isset($lecturer) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="staff_id"
            label="Staff Id"
            :value="old('staff_id', ($editing ? $lecturer->staff_id : ''))"
            maxlength="255"
            placeholder="Staff Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $lecturer->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="faculty_id" label="Faculty" required>
            @php $selected = old('faculty_id', ($editing ? $lecturer->faculty_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Faculty</option>
            @foreach($faculties as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
