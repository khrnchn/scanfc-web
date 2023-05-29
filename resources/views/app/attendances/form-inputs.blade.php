@php $editing = isset($attendance) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="student_id" label="Student" required>
            @php $selected = old('student_id', ($editing ? $attendance->student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Student</option>
            @foreach($students as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="classroom_id" label="Classroom" required>
            @php $selected = old('classroom_id', ($editing ? $attendance->classroom_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Classroom</option>
            @foreach($classrooms as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="status"
            label="Status"
            :value="old('status', ($editing ? $attendance->status : ''))"
            maxlength="255"
            placeholder="Status"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
