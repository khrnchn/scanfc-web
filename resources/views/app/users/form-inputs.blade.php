@php $editing = isset($user) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $user->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="phone_no"
            label="Phone No"
            :value="old('phone_no', ($editing ? $user->phone_no : ''))"
            maxlength="255"
            placeholder="Phone No"
            required
        ></x-inputs.text>
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
