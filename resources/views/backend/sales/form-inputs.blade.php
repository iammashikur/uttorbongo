@php $editing = isset($sale) @endphp

<div class="row">

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="product_code_id" label="Product" required>
            @php $selected = old('product_code_id', ($editing ? $sale->product_code_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Product Code</option>
            @foreach($productCodes as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="buyer_id" label="Buyer" required>
            @php $selected = old('buyer_id', ($editing ? $sale->buyer_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Buyer</option>
            @foreach($buyers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

</div>
