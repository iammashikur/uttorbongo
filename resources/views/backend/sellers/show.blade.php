@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('sellers.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.sellers.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.sellers.inputs.name')</h5>
                    <span>{{ $seller->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sellers.inputs.phone')</h5>
                    <span>{{ $seller->phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sellers.inputs.address')</h5>
                    <span>{{ $seller->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sellers.inputs.image')</h5>
                    <x-partials.thumbnail
                        src="{{ $seller->image ? \Storage::url($seller->image) : '' }}"
                        size="150"
                    />
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.sellers.inputs.document')</h5>
                    @if($seller->document)
                    <a
                        href="{{ \Storage::url($seller->document) }}"
                        target="blank"
                        ><i class="icon ion-md-download"></i>&nbsp;Download</a
                    >
                    @else - @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('sellers.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Seller::class)
                <a href="{{ route('sellers.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
