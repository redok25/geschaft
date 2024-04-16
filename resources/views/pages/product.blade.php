@extends('layouts.app')
@section('web-title', 'Product')
@section('title', 'Product')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header justify-content-between">
                    <h4>Product</h4>
                    <button class="btn btn-primary btn-add" onclick="show_modal('product')">
                        <i class="fa fa-plus"></i>
                        Add Product
                    </button>
                </div>
                <div class="card-body">
                    <?php $url = route('product'); ?>
                    <x-datatables-server-side name='product' :header="['_search', 'Product', 'Price']" :url='$url'>
                        <x-slot name="callback">
                            <script>
                                // Function name must 'callback'
                                const callback = () => {
                                    $('.data-edit').on('click', function() {
                                        let data = $(this).data('item')

                                        show_modal('product');

                                        $.each(Object.keys(validate_product.fields), function(i, v) {
                                            $(`#form-product [name=${v}]`).val(data[v])
                                        })

                                        $(`#form-product [name=data_id]`).val(data.id)

                                    })
                                    $('.data-delete').on('click', function() {
                                        let id = $(this).data('id');

                                        Swal.fire({
                                            title: 'Are you sure?',
                                            text: 'Click "Ok" then this data will be deleted!',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ok',
                                            cancelButtonText: 'Cancel',
                                            customClass: {
                                                confirmButton: 'mx-1 btn btn-danger',
                                                cancelButton: 'mx-1 btn btn-light',
                                            },
                                            buttonsStyling: false
                                        }).then((result) => {
                                            if (result.isConfirmed) {
                                                let url = "{{ route('product.delete', '@ID@') }}"
                                                window.location.href = url.replace(/@ID@/g, id);
                                            }
                                        });
                                    })
                                };
                            </script>
                        </x-slot>

                        <script>
                            // Var name must 'columns'
                            columns = [{
                                    visible: false,
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: null,
                                    orderable: false,
                                    searchable: false,
                                    class: 'text-start',
                                    render: function(data, type, row) {
                                        let el = `
                                            ${data.name}
                                            <div class="">
                                                <a href="#" class="data-edit" data-item='${JSON.stringify(data)}'>Edit</a>
                                                <div class="bullet"></div>
                                                <a href="#" class="text-danger data-delete" data-id="${data.id}">Delete</a>
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
                                            ${data.price}
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
    <form action="" id="form-product" method="POST" enctype="multipart/form-data">
        @csrf
        <input class="rdk-input" type="hidden" value="" name="data_id">
        <div class="modal fade" tabindex="-1" role="dialog" id="modal-product">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="modal-ket-product"></span> Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control rdk-input">
                        </div>

                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control rdk-input">
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="button-product">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function show_modal(name) {
            $(`#form-${name} .rdk-input`).val('');
            $(`#modal-${name}`).modal('show');
        }
    </script>
    <x-form-validation name="product">
        <script>
            // *! Var name must 'validator'
            validator = {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Product name required"
                        },
                    }
                },

                price: {
                    validators: {
                        notEmpty: {
                            message: "Price required"
                        },
                    }
                },
            }
        </script>
    </x-form-validation>
@endpush
