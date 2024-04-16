@extends('layouts.app')
@section('web-title', 'Order')
@section('title', 'Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="" id="form-order" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header justify-content-between">
                        <h4>Order</h4>
                        <button type="button" class="btn btn-primary" onclick="add_product()">
                            <i class="fa fa-plus"></i>
                            Add Product
                        </button>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Customer</label>
                                    <select class="form-control select2" name="customer">
                                        <option value="" selected disabled>-- Choose Customer --</option>
                                        @foreach ($customer as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <b>List Product</b>
                                <hr>
                                <div class="row product-container">

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex" style="justify-content: right">
                        <button type="button" class="btn btn-light mr-2" onclick="reset_product()">Reset</button>
                        <button type="submit" class="btn btn-primary">Order</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>List Order</h4>
                </div>
                <div class="card-body">
                    <?php $url = route('sale'); ?>
                    <x-datatables-server-side name='order' :header="['Customer', 'Total']" :url='$url'>
                        <x-slot name="callback">
                            <script>
                                // Function name must 'callback'
                                const callback = () => {
                                    $('.data-detail').on('click', function() {
                                        let data = $(this).data('item')
                                        show_modal(data);
                                    })
                                };
                            </script>
                        </x-slot>

                        <script>
                            // Var name must 'columns'
                            columns = [{
                                    data: null,
                                    orderable: false,
                                    searchable: false,
                                    class: 'text-start',
                                    render: function(data, type, row) {
                                        let el = `
                                            ${data.customer.name}
                                            <div class="">
                                                <a href="#" class="data-detail" data-item='${JSON.stringify(data)}'>Detail</a>
                                            </div>
                                        `;
                                        return el;
                                    }
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    searchable: false,
                                    class: 'text-start',
                                    render: function(data, type, row) {
                                        let el = `Rp.
                                            ${data.total}
                                        `;
                                        return el;
                                    }
                                },
                            ]
                        </script>
                    </x-datatables-server-side>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal-content')
    <div class="modal fade" tabindex="-1" role="dialog" id="modal-order">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>QTY</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody class="detail-order"></tbody>
                        <tfoot class="footer-order"></tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Init
        $(document).ready(function() {
            add_product();
        });
    </script>

    <script>
        let NUM_PRODUCT = 0;

        function show_modal(data) {
            console.log(data);
            $(`#modal-order`).modal('show');

            $('.detail-order').html('');
            $('.footer-order').html('');

            data.detail.forEach(v => {
                $('.detail-order').append(`
                    <tr>
                        <td>${v.product.name}</td>
                        <td>Rp. ${v.product.price}</td>
                        <td>${parseFloat(v.qty).toFixed(0)}</td>
                        <td>Rp. ${v.total}</td>
                    </tr>
                `)
            });

            $('.footer-order').append(`
                <tr>
                    <th colspan="3">Total</th>
                    <th>Rp. ${data.total}</th>
                </tr>
            `)
        }

        function add_product() {
            let el = `
                <div class="col-12 product-item text-left d-flex justify-content-between flex-wrap" data-number-product="${NUM_PRODUCT}">
                    <div class="form-group d-flex flex-column">
                        <label>Product</label>
                        <select class="form-control select-product" name="order[${NUM_PRODUCT}][product]">
                            <option value="" selected disabled>-- Choose Product --</option>
                            @foreach ($product as $item)
                                <option data-item='@json($item)' value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group d-flex flex-column">
                        <label>Price</label>
                        <input type="hidden" class="product-input-price" name="order[${NUM_PRODUCT}][price]">
                        <p class="product-price">Rp. 0</p>
                    </div>

                    <div class="form-group d-flex flex-column">
                        <label>QTY</label>
                        <input class="form-control product-input-qty" type="number" name="order[${NUM_PRODUCT}][qty]"
                            value="0">
                    </div>

                    <div class="form-group d-flex flex-column">
                        <input class="product-input-total" type="hidden" name="order[${NUM_PRODUCT}][total]">
                        <label>Total</label>
                        <p class="product-total">Rp. 0</p>
                    </div>

                    <div class="form-group d-flex flex-column">
                        <label style="opacity: 0">Action</label>
                        <button class="btn btn-danger btn-icon" onclick="delete_product(${NUM_PRODUCT})"><i
                                class="fa fa-trash"></i></button>
                    </div>
                </div>
            `;

            $('.product-container').append(el);

            $('.select-product').select2();
            $('.select-product').change(function() {
                let qty = $(this).closest('.product-item').find('.product-input-qty').val()
                let price = $(this).find('option:selected').data('item')['price'];
                $(this).closest('.product-item').find('.product-input-price').val(price)
                $(this).closest('.product-item').find('.product-price').text(`Rp. ${price}`)
                $(this).closest('.product-item').find('.product-input-total').val(qty * price)
                $(this).closest('.product-item').find('.product-total').text(`Rp. ${(qty * price)}`)
            })
            $('.product-input-qty').on('input', function() {
                let qty = $(this).val();
                let price = $(this).closest('.product-item').find('.product-input-price').val()
                $(this).closest('.product-item').find('.product-input-total').val(qty * price)
                $(this).closest('.product-item').find('.product-total').text(`Rp. ${(qty * price)}`)
            })
            NUM_PRODUCT++;
        }

        function delete_product(num) {
            $(`[data-number-product=${num}]`).remove();
        }

        function reset_product() {
            NUM_PRODUCT = 1;
            $('.product-container').html('');
            $(`[name=customer]`).val('').trigger('change');
            add_product();
        }
    </script>

    <script></script>
@endpush
