@extends('layouts.guest')
@section('web-title', 'Login')
@section('class-card', 'col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4')

@section('content')

    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" id="form-login">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required
                        autofocus>
                </div>

                <div class="form-group">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4" id="button-login">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


@push('scripts')
    @if (!empty($errors->all()))
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

    <x-form-validation name="login">
        <script>
            // *! Var name must 'validator'
            let validator = {
                email: {
                    validators: {
                        notEmpty: {
                            message: "Email field required"
                        },
                        emailAddress: {
                            message: 'The value is not a valid email address',
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
            }
        </script>
    </x-form-validation>
@endpush
