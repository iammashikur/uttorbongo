@php $editing = isset($brand) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $brand->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="logo"
            label="Logo"
            :value="old('logo', ($editing ? $brand->logo : ''))"
            maxlength="255"
            placeholder="Logo"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
