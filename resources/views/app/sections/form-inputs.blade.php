@php $editing = isset($section) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="subject_id" label="Subject" required>
            @php $selected = old('subject_id', ($editing ? $section->subject_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Subject</option>
            @foreach($subjects as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $section->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
