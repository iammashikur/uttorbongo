@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('buyers.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.buyers.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.buyers.inputs.name')</h5>
                    <span>{{ $buyer->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.buyers.inputs.address')</h5>
                    <span>{{ $buyer->address ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.buyers.inputs.phone')</h5>
                    <span>{{ $buyer->phone ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.buyers.inputs.email')</h5>
                    <span>{{ $buyer->email ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.buyers.inputs.document')</h5>
                    @if($buyer->document)
                    <a
                        href="{{ \Storage::url($buyer->document) }}"
                        target="blank"
                        ><i class="icon ion-md-download"></i>&nbsp;Download</a
                    >
                    @else - @endif
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('buyers.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Buyer::class)
                <a href="{{ route('buyers.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
