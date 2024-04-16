@extends('layouts.app')

@section('web-title', 'Test Datatables')
@section('title', 'Test Datatables')

@push('styles')
    <style>
        label.error {
            color: red;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Data Test Datatables</h4>
                </div>
                <div class="card-body">
                    <?php $url = route('test.datatables'); ?>
                    <x-datatables-server-side name='test' :header="['Name', 'Email', 'Role', 'Action']" :url='$url'>
                        <x-slot name="callback">
                            <script>
                                // Function name must 'callback'
                                const callback = () => {
                                    $('.btn-show').on('click', function() {
                                        Swal.fire('Test!?')
                                    })
                                };
                            </script>
                        </x-slot>

                        <script>
                            // Var name must 'columns'
                            columns = [{
                                data: 'name',
                                name: 'name'
                            }, {
                                data: 'email',
                                name: 'email'
                            }, {
                                data: 'role',
                                name: 'role'
                            }, {
                                data: null,
                                orderable: false,
                                searchable: false,
                                render: function(data, type, row) {
                                    let el = `
                                <button class="btn btn-primary btn-icon btn-show">
                                    <i class="fa fa-eye"></i>
                                </button>
                            `;

                                    return el;
                                }
                            }]
                        </script>
                    </x-datatables-server-side>
                </div>
            </div>
        </div>
    </div>
@endsection
