@php $editing = isset($classroom) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="subject_id" label="Subject" required>
            @php $selected = old('subject_id', ($editing ? $classroom->subject_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Subject</option>
            @foreach($subjects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="section_id" label="Section" required>
            @php $selected = old('section_id', ($editing ? $classroom->section_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Section</option>
            @foreach($sections as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="lecturer_id" label="Lecturer" required>
            @php $selected = old('lecturer_id', ($editing ? $classroom->lecturer_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Lecturer</option>
            @foreach($lecturers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $classroom->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="start_at"
            label="Start At"
            value="{{ old('start_at', ($editing ? optional($classroom->start_at)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="end_at"
            label="End At"
            value="{{ old('end_at', ($editing ? optional($classroom->end_at)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>
</div>
