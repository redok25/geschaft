@extends('layouts.app')
@section('web-title', 'Profile')

@section('content')
    <div class="row gap-5">
        <div class="col-md-6 col-12">
            <div class="card">
                <form method="post" action="{{ route('profile.update') }}" id="form-profile">
                    @csrf
                    @method('PATCH')
                    <div class="card-header">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="name" name="name" class="form-control" placeholder="Name"
                                value="{{ auth()->user()->name }}" required="">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="button-profile">Save</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="card">
                <form method="post" action="{{ route('password.update') }}" id="form-password">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4>Update Password</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>Current Password</label>
                            <input type="password" class="form-control" name="current_password">
                        </div>

                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="form-group">
                            <label>Password Confirmation</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" id="button-password">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if (count($errors->updatePassword) > 0)
        <?php
        $error;
        if (!empty($errors->updatePassword->get('password'))) {
            $error = $errors->updatePassword->get('password')[0];
        }
        if (!empty($errors->updatePassword->get('password_confirmation'))) {
            $error = $errors->updatePassword->get('password_confirmation')[0];
        }
        if (!empty($errors->updatePassword->get('current_password'))) {
            $error = $errors->updatePassword->get('current_password')[0];
        }
        ?>
        <script>
            Swal.fire({
                "title": "{{ $error }}",
                "text": "",
                "timer": 5000,
                "background": "#fff",
                "width": "26rem",
                "padding": "0.75rem",
                "showConfirmButton": false,
                "showCloseButton": true,
                "confirmButtonText": "OK",
                "cancelButtonText": "Cancel",
                "timerProgressBar": false,
                "customClass": {
                    "container": null,
                    "popup": null,
                    "header": null,
                    "title": null,
                    "closeButton": null,
                    "icon": null,
                    "image": null,
                    "content": null,
                    "input": null,
                    "actions": null,
                    "confirmButton": null,
                    "cancelButton": null,
                    "footer": null
                },
                "toast": true,
                "icon": "error",
                "position": "top-end"
            });
        </script>
    @endif

    @if (count($errors->all()) > 0)
        <script>
            Swal.fire({
                "title": "{{ $errors->all()[0] }}",
                "text": "",
                "timer": 5000,
                "background": "#fff",
                "width": "26rem",
                "padding": "0.75rem",
                "showConfirmButton": false,
                "showCloseButton": true,
                "confirmButtonText": "OK",
                "cancelButtonText": "Cancel",
                "timerProgressBar": false,
                "customClass": {
                    "container": null,
                    "popup": null,
                    "header": null,
                    "title": null,
                    "closeButton": null,
                    "icon": null,
                    "image": null,
                    "content": null,
                    "input": null,
                    "actions": null,
                    "confirmButton": null,
                    "cancelButton": null,
                    "footer": null
                },
                "toast": true,
                "icon": "error",
                "position": "top-end"
            });
        </script>
    @endif

    <x-form-validation name="profile">
        <script>
            // *! Var name must 'validator'
            validator = {
                name: {
                    validators: {
                        notEmpty: {
                            message: "Name field required"
                        },
                    }
                },
            }
        </script>
    </x-form-validation>

    <x-form-validation name="password">
        <script>
            // *! Var name must 'validator'
            validator = {
                current_password: {
                    validators: {
                        notEmpty: {
                            message: "Current password field required"
                        },
                    }
                },

                password: {
                    validators: {
                        notEmpty: {
                            message: "Password field required"
                        },
                    }
                },

                password_confirmation: {
                    validators: {
                        notEmpty: {
                            message: "Password confirmation field required"
                        },
                    }
                },
            }
        </script>
    </x-form-validation>
@endpush
