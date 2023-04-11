@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                    <a href="{{ route('products.index') }}" class="mr-4"><i class="icon ion-md-arrow-back"></i></a>
                    @lang('crud.products.create_title')
                </h4>

                <x-form method="POST" action="{{ route('products.store') }}" has-files class="mt-4">
                    @include('backend.products.form-inputs')

                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-light">
                            <i class="icon ion-md-return-left text-primary"></i>
                            @lang('crud.common.back')
                        </a>

                        <button type="submit" class="btn btn-primary float-right">
                            <i class="icon ion-md-save"></i>
                            @lang('crud.common.create')
                        </button>
                    </div>
                </x-form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            $('select[name="seller_id"]').parent().hide();
            $('select[name="supplier_id"]').parent().hide();

            $("select[name='product_type']").on('change', function() {

                var product_type = $(this).val();
                if (product_type == 'new') {
                    $('select[name="supplier_id"]').parent().show();
                    $('select[name="seller_id"]').parent().hide();
                } else {
                    $('select[name="supplier_id"]').parent().hide();
                    $('select[name="seller_id"]').parent().show();
                }
            });

        });
    </script>
@endpush
