<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/5.2.3/zephyr/bootstrap.min.css"
        integrity="sha512-dcTg+pv6j02FTyko5ua8nsnARs/l4u43vmnbeVgkFWB5wdLgfUq4CEotFWOlTE4XK7FfVriWj7BrpqET/a+SJQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/font-awesome-6-pro/css/all.css') }}">
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>POS</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">

    <style>
        .card {
            min-height: 75vh;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px !important;
        }

        .product-search .form-control {
            box-shadow: unset;
        }

        thead th {
            font-size: .875rem;
            text-transform: unset;
        }

        .row-index {
            display: none;
        }

        .exchange {
            background: #f2f2f2;
            height: 2rem;
            width: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            cursor: pointer;
            transition: 1s;
        }
        .exchange:hover {
            background: #212529;
            transform: rotate(180deg);
            transition: 1s;
            color: #fff;
        }

        @media print {



            .form-control {
                padding: 0px;
                border: navajowhite;
                box-shadow: none;
            }

            .card {
                box-shadow: unset !important;
            }

            .d-print-none {
                display: none !important;
            }

            .d-print-block {
                display: block !important;
            }

            .row-index {
                display: block;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark d-print-none">
        <div class="container">
            <a class="navbar-brand" href="">Uttorbongo</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor02"
                aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}"><i class="fa-duotone fa-gauge"></i>
                            Dashboard
                            <span class="visually-hidden">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-duotone fa-earth-asia"></i> Website</a>
                    </li>


                </ul>
                <form class="d-flex">
                    <input class="form-control me-sm-2" type="search" placeholder="Search">
                    <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i
                            class="fa-duotone fa-magnifying-glass"></i></button>
                </form>
            </div>
        </div>
    </nav>


    <div class="container mt-4 mb-4">

        <div class="row">



            <div class="col-md-8">
                <div class="card border-secondary mb-3">

                    <div class="card-body">

                        <div class="d-flex justify-content-between">

                            <div class="p-1 bg-light rounded rounded-3 shadow-sm mb-4 product-search d-print-none"
                                style="max-width: 15rem">
                                <form id="pos-search" method="POST">
                                    <div class="input-group">
                                        <input type="search" placeholder="Search Product"
                                            aria-describedby="button-addon" name="search"
                                            class="form-control border-0 bg-light">

                                        <div class="input-group-append">
                                            <div id="search-spinner"
                                                class="spinner-border spinner-border-sm text-primary mt-1"
                                                role="status">
                                                <span class="visually-hidden">Loading...</span>
                                            </div>
                                            <button id="button-addon" type="submit"
                                                class="btn btn-link text-primary"><i
                                                    class="fa-duotone fa-magnifying-glass"></i></button>

                                        </div>
                                    </div>
                                </form>


                            </div>
                            <div class="exchange">
                                <i class="fa-duotone fa-arrows-rotate"></i>
                            </div>

                        </div>





                        <div class="row search-data">

                        </div>


                        <table class="table table-bordered">

                            <thead>
                                <tr>
                                    <th scope="col"><i class="fa-duotone fa-cart-shopping-fast"></i></th>
                                    <th class="d-print-none" scope="col">Image</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Serial</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Total</th>

                                </tr>
                            </thead>

                            <tbody id="items">


                            </tbody>
                            <tbody>
                                <tr>
                                    <td class="d-print-none"></td>
                                    <td colspan="3"></td>
                                    <td colspan="2">Subtotal</td>

                                    <td id="subtotal">0.00</td>
                                </tr>

                                <tr id="paid_amount_tr" class="d-none">

                                    <td class="d-print-none"></td>
                                    <td colspan="3"></td>
                                    <td colspan="2">Paid Amount</td>
                                    <td id="paid_amount">0.00</td>
                                </tr>

                                <tr id="due_amount_tr" class="d-none">
                                    <td class="d-print-none"></td>
                                    <td colspan="3"></td>
                                    <td colspan="2">Due</td>
                                    <td id="due_amount">0.00</td>
                                </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-secondary mb-3 d-print-none">

                    <div class="card-body">

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="photo" class="form-label">Photo</label>
                            <input type="file" class="form-control" id="name" name="photo"
                                placeholder="">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="">
                        </div>

                        <div class="row">
                            <div class="col-6">

                                <div class="mb-3">
                                    <label for="paid" class="form-label">Paid</label>
                                    <input type="number" class="form-control" id="paid" name="paid"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="due" class="form-label">Due</label>
                                    <input type="number" class="form-control" id="due" name="due"
                                        placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" id="checkout" class="btn btn-primary"><i
                                    class="fa-duotone fa-cart-circle-check"></i>
                                Checkout </button>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>


    <style>
        .product {
            border: 1px solid #ccc;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }

        .product:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }

        .product-info {
            display: flex;
            align-items: center;
            padding: 0.5rem;
        }

        .product-image {
            width: 30%;
            height: 60px;
            object-fit: cover;
            border-radius: 0.25rem;
            margin-right: 1rem;
        }

        .product-description {
            padding: 10px;
        }

        .product-title {
            font-size: 12px;
        }

        .product-category {
            font-size: 10px;
            font-weight: 200;
        }

        .badge {
            font-size: 10px;
            font-weight: 200;
            padding: 5px 10px;
        }

        .stock {
            font-size: 8px;
        }
    </style>


    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        //notify success
        var notyf = new Notyf({
            dismissible: true
        })

        var subtotal = 0;
        var product_codes = [];

        //onload
        $(document).ready(function() {

            //hide spinner
            $('#search-spinner').hide();
            //search product
            $('#pos-search').on('submit', function(e) {
                e.preventDefault();
                var search = $('input[name="search"]').val();
                $.ajax({
                    url: "{{ route('pos-search') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: search
                    },
                    //before load
                    beforeSend: function() {
                        //show spinner
                        $('#search-spinner').show();
                    },
                    success: function(data) {

                        //hide spinner
                        $('#search-spinner').hide();

                        var html = '';

                        $.each(data, function(key, value) {
                            html += `
                            <div class="col-md-4">
                                <div class="product border rounded-2 mb-4" data-json='${JSON.stringify(value)}'>
                                    <div class="product-info">
                                    <img src="${value.image}" alt="${value.image}" class="product-image">
                                    <div class="product-description">
                                        <h3 class="product-title">${value.name} <small style="stock"> (Stock - ${value.codes.length})</small></h3>
                                        <p class="mb-0 product-category">${value.category}</p>
                                        <span class="badge rounded-pill bg-light border">BDT ${value.price}</span>
                                    </div>
                                    </div>
                                </div>
                            </div>
                           `;
                        });

                        $('.search-data').html(html);




                        //hide spinner
                        $('#search-spinner').hide();

                    },
                    error: function(data) {
                        console.log(data);
                    }
                });
            });


            //product click
            $(document).on('click', '.product', function() {
                var data = $(this).data('json');

                //check if product code is already in the array
                if (product_codes.includes(data.code)) {
                    //set search data to empty
                    $('.search-data').html('');
                    return;
                }

                //dont populate if already exist
                if ($('#' + data.code).length) {
                    return;
                }

                //if product id is already in the table add quantity
                if ($(`[data-product-id="${data.id}"]`).length) {
                    var qty = $(`[data-product-id="${data.id}"] input`).val();


                    //check quantity if not greather than stock
                    if (parseInt(qty) + 1 <= data.codes.length) {
                        $(`[data-product-id="${data.id}"] input`).val(parseInt(qty) + 1);
                        //add change event to quantity
                        $(`[data-product-id="${data.id}"] input`).trigger('change');
                    }

                    //add to product codes
                    product_codes.push(data.code);

                    $('.search-data').html('');

                    console.log(product_codes);

                    return;
                }

                //populate table items
                var html = `
                <tr id="${data.code}" data-product-id="${data.id}" data-product-codes="${data.codes}">
                    <th><span class="row-index">  </span> <i data-remove="${data.code}" class="fa-duotone fa-cart-circle-xmark text-danger d-print-none"></i></th>
                    <td class="d-print-none"><img src="${data.image}" alt="${data.image}" width="100"></td>
                    <td>${data.name}</td>
                    <td><span class="badge rounded-pill bg-light border">#${data.code}</span> </td>
                    <td>
                        <input data-codes="${data.codes}" data-code="${data.code}" max="${data.codes.length}" min="1" type="number" class="form-control" id="qty" name="qty" placeholder="Qty" value="1">
                    </td>
                    <td data-price-identifier="${data.code}">${data.price}</td>
                    <td data-total-identifier="${data.code}">${data.price}</td>
                </tr>
                `;


                $('#items').append(html);

                //add to product codes
                product_codes.push(data.code);

                //clear search
                $('.search-data').html('');

                //calculate subtotal
                subtotal += parseInt(data.price);
                //to decimal
                subtotal_dec = subtotal.toFixed(2);
                $('#subtotal').text(subtotal_dec);

                //set row index
                $('.row-index').each(function(index) {
                    $(this).text(index + 1);
                });


            });

            //qty change
            $(document).on('change input keyup', '#qty', function() {


                //get product codes
                var codes = $(this).data('codes').split(',');

                //if quantity is greater than stock
                if ($(this).val() > codes.length) {
                    $(this).val(codes.length);
                }
                //if quantity is less than 1
                if ($(this).val() < $(this).attr('min')) {
                    $(this).val($(this).attr('min'));
                }

                //get current product code
                var code = $(this).data('code');

                //get current qty and minus 1 to get index
                var index = $(this).val() - 1;


                //take product codes according to qty from product codes array
                var product_codes__ = codes.splice(0, $(this).val());

                var codes_html = '';

                //append product_codes to product code td usinf foreach
                $.each(product_codes__, function(key, value) {
                    //push to product codes if not already exist
                    if (!product_codes.includes(value)) {
                        product_codes.push(value);
                    }

                    codes_html += ' <span class="badge rounded-pill bg-light border">#' + value +
                        '</span>';
                });

                //get remaining product codes
                var remaining = codes.filter(function(item) {
                    return !product_codes__.includes(item);
                });

                // remove remaining product codes from product codes array
                $.each(remaining, function(key, value) {
                    var index = product_codes.indexOf(value);
                    if (index > -1) {
                        product_codes.splice(index, 1);
                    }
                });

                //append to product code td
                $(this).parent().parent().find('td:nth-child(4)').html(codes_html);

                var qty = $(this).val();
                var price = $('[data-price-identifier="' + code + '"]').text();
                var total = qty * price;
                //set total using data-total-identifier
                $('[data-total-identifier="' + code + '"]').text(total.toFixed(2));
                //calculate subtotal
                subtotal = 0;
                $('[data-total-identifier]').each(function() {
                    subtotal += parseInt($(this).text());
                });
                //to decimal
                subtotal_dec = subtotal.toFixed(2);
                $('#subtotal').text(subtotal_dec);

                console.log(product_codes);

            });

            //remove item
            $(document).on('click', '[data-remove]', function() {

                var code = $(this).data('remove');
                //remove row
                $('#' + code).remove();
                //calculate subtotal
                subtotal = 0;
                $('[data-total-identifier]').each(function() {
                    subtotal += parseInt($(this).text());
                });
                //to decimal
                subtotal_dec = subtotal.toFixed(2);
                $('#subtotal').text(subtotal_dec);

                //get data-product-codes using  data-product-id and split it multiple product codes

                var codes = $(this).parent().parent().data('product-codes');

                if (typeof codes === 'string' && codes.includes(',')) {
                    codes = codes.split(',');
                } else {
                    codes = [codes];
                }

                //remove product codes from product codes array
                $.each(codes, function(key, value) {
                    //remove product code from product codes array
                    var index = product_codes.indexOf('' + value); //int to string
                    if (index > -1) {
                        product_codes.splice(index, 1);
                    }

                });

            });

        });

        //on change paid calculate due
        $(document).on('change keyup input', '#paid', function() {
            //if subtotal 0
            if (subtotal == 0) {
                //due 0.00
                $('#due').val('0.00');
                return;
            }
            var paid = $(this).val();
            var due = subtotal - paid;


            $('#due').val(due.toFixed(2));


            //show due_amount_tr
            $('#due_amount_tr').removeClass('d-none');
            //show paid_amount_tr
            $('#paid_amount_tr').removeClass('d-none');

            //update paid_amount column
            $('#paid_amount').html(parseFloat(paid).toFixed(2));


            //update due_amount column
            $('#due_amount').html(due.toFixed(2));

            //if due is negative
            if (due <= 0) {
                //hide due_amount_tr
                $('#due_amount_tr').addClass('d-none');
            }

            if (paid <= 0) {
                //hide paid_amount_tr
                $('#paid_amount_tr').addClass('d-none');
            }

        });

        //On checkout
        $(document).on('click', '#checkout', function() {

            event.preventDefault();

            //if subtotal 0
            if (subtotal == 0) {
                alert('Please add items to cart');
                return;
            }
            //if paid 0
            if ($('#paid').val() == 0) {
                alert('Please enter paid amount');
                return;
            }
            //if due 0
            if ($('#due').val() == 0) {
                alert('Please enter due amount');
                return;
            }
            //if due is negative
            if ($('#due').val() < 0) {
                alert('Please enter valid paid amount');
                return;
            }

            //get customer id
            var customer_id = 1;
            //get paid
            var paid = $('#paid').val();
            //get due
            var due = $('#due').val();
            //get product codes
            var product_codes = product_codes;

            //ajax request
            $.ajax({
                url: "{{ route('checkout') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    customer_id: customer_id,
                    paid: paid,
                    due: due,
                    product_codes: product_codes
                },
                success: function(data) {

                    console.log(data);

                    //if success
                    if (data.success) {


                        notyf.success(data.message);

                        setTimeout(function() {
                            window.print();
                            location.reload();
                        }, 3000);


                    }
                    //if error
                    if (data.error) {
                        //alert error
                        alert(data.error);
                    }
                }
            });
        });

        //on input phone number
        $(document).on('input', '#phone', function() {
            //get phone number
            var phone = $(this).val();
            //if phone number length is 11
            if (phone.length == 11) {
                //ajax request
                $.ajax({
                    url: "{{ route('customer') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone: phone
                    },
                    success: function(data) {
                        //if success
                        if (data.success) {
                            //set customer name
                            $('#customer_name').val(data.customer.name);
                            //set customer id
                            $('#customer_id').val(data.customer.id);
                        }
                        //if error
                        if (data.error) {
                            //set customer name
                            $('#customer_name').val('');
                            //set customer id
                            $('#customer_id').val('');
                        }
                    }
                });
            }
        });
    </script>


</body>

</html>
