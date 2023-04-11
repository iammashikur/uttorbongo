@extends('layouts.app')

@section('content')
<div class="container">
    <div class="searchbar mt-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="input-group">
                        <input
                            id="indexSearch"
                            type="text"
                            name="search"
                            placeholder="{{ __('crud.common.search') }}"
                            value="{{ $search ?? '' }}"
                            class="form-control"
                            autocomplete="off"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="icon ion-md-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-right">
                @can('create', App\Models\Product::class)
                <a
                    href="{{ route('products.create') }}"
                    class="btn btn-primary"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h4 class="card-title">@lang('crud.products.index_title')</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.products.inputs.name')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.product_category_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.brand_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.image')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.product_type')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.supplier_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.products.inputs.seller_id')
                            </th>
                            <th class="text-right">
                                @lang('crud.products.inputs.purchase_price')
                            </th>
                            <th class="text-right">
                                @lang('crud.products.inputs.price')
                            </th>
                            <th class="text-center">
                                @lang('Quantity')
                            </th>

                            <th class="text-left">
                                @lang('crud.products.inputs.show_on_website')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>{{ $product->name ?? '-' }}</td>
                            <td>
                                {{ optional($product->productCategory)->name ??
                                '-' }}
                            </td>
                            <td>
                                {{ optional($product->brand)->name ?? '-' }}
                            </td>
                            <td>
                                <x-partials.thumbnail
                                    src="{{ $product->image ? \Storage::url($product->image) : '' }}"
                                />
                            </td>
                            <td>{{ $product->product_type ?? '-' }}</td>
                            <td>
                                @if ($product->supplier)
                                <a href="{{  route('suppliers.show', $product->supplier->id) }}"> {{  $product->supplier->name }} </a>
                                @else
                                <small class="text-muted text-italic">N/A</small>
                                @endif
                            </td>
                            <td>
                                @if ($product->seller)
                                <a href="{{  route('sellers.show', $product->seller->id) }}"> {{  $product->seller->name }} </a>
                                @else
                                <small class="text-muted text-italic">N/A</small>
                                @endif
                            </td>
                            <td>{{ $product->purchase_price ?? '-' }}</td>
                            <td>{{ $product->price ?? '-' }}</td>
                            <td>{{ $product->products->where('status' , 0)->count() }}</td>
                            <td>{!! $product->show_on_website ? '<i class="fa-duotone fa-shop"></i>' : '<i class="fa-duotone fa-shop-slash"></i>' !!}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $product)
                                    <a
                                        href="{{ route('products.edit', $product) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $product)
                                    <a
                                        href="{{ route('products.show', $product) }}"
                                    >
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $product)
                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                    >
                                        @csrf @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn btn-light text-danger"
                                        >
                                            <i class="icon ion-md-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="12">{!! $products->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
