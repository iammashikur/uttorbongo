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
                @can('create', App\Models\Sale::class)
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="mb-4">
                <h4 class="card-title">@lang('crud.sales.index_title')</h4>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="text-left">
                                @lang('crud.sales.inputs.product_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.sales.inputs.product_code_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.sales.inputs.buyer_id')
                            </th>
                            <th class="text-right">
                                @lang('crud.sales.inputs.purchase_price')
                            </th>
                            <th class="text-right">
                                @lang('crud.sales.inputs.sale_price')
                            </th>
                            <th class="text-left">
                                @lang('crud.sales.inputs.user_id')
                            </th>
                            <th class="text-left">
                                @lang('crud.sales.inputs.shop_id')
                            </th>
                            <th class="text-center">
                                @lang('crud.common.actions')
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ optional($sale->product)->name ?? '-' }}</td>
                            <td>
                                {{ optional($sale->productCode)->product_code ??
                                '-' }}
                            </td>
                            <td>{{ optional($sale->buyer)->name ?? '-' }}</td>
                            <td>{{ $sale->purchase_price ?? '-' }}</td>
                            <td>{{ $sale->sale_price ?? '-' }}</td>
                            <td>{{ optional($sale->user)->name ?? '-' }}</td>
                            <td>{{ optional($sale->shop)->name ?? '-' }}</td>
                            <td class="text-center" style="width: 134px;">
                                <div
                                    role="group"
                                    aria-label="Row Actions"
                                    class="btn-group"
                                >
                                    @can('update', $sale)
                                    <a href="{{ route('sales.edit', $sale) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-create"></i>
                                        </button>
                                    </a>
                                    @endcan @can('view', $sale)
                                    <a href="{{ route('sales.show', $sale) }}">
                                        <button
                                            type="button"
                                            class="btn btn-light"
                                        >
                                            <i class="icon ion-md-eye"></i>
                                        </button>
                                    </a>
                                    @endcan @can('delete', $sale)
                                    <form
                                        action="{{ route('sales.destroy', $sale) }}"
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
                            <td colspan="8">
                                @lang('crud.common.no_items_found')
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="8">{!! $sales->render() !!}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
