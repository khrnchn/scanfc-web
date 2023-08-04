@php $editing = isset($student) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="matrix_id"
            label="Matrix Id"
            :value="old('matrix_id', ($editing ? $student->matrix_id : ''))"
            maxlength="255"
            placeholder="Matrix Id"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nfc_tag"
            label="Nfc Tag"
            :value="old('nfc_tag', ($editing ? $student->nfc_tag : ''))"
            maxlength="255"
            placeholder="Nfc Tag"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $student->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="faculty_id" label="Faculty" required>
            @php $selected = old('faculty_id', ($editing ? $student->faculty_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Faculty</option>
            @foreach($faculties as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="is_active"
            label="Is Active"
            :checked="old('is_active', ($editing ? $student->is_active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
