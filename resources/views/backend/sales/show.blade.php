@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('sales.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.sales.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.product_id')</h5>
                    <span>{{ optional($sale->product)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.product_code_id')</h5>
                    <span
                        >{{ optional($sale->productCode)->product_code ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.buyer_id')</h5>
                    <span>{{ optional($sale->buyer)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.purchase_price')</h5>
                    <span>{{ $sale->purchase_price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.sale_price')</h5>
                    <span>{{ $sale->sale_price ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.user_id')</h5>
                    <span>{{ optional($sale->user)->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sales.inputs.shop_id')</h5>
                    <span>{{ optional($sale->shop)->name ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('sales.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Sale::class)
                <a href="{{ route('sales.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
