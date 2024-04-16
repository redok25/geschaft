{{--
    HOW TO USE
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
--}}

{{ $slot }}

<script>
    let validators_{{ $name }} = validator
    let form_{{ $name }} = document.querySelector("#form-{{ $name }}")
    let button_{{ $name }} = document.querySelector("#button-{{ $name }}")
    let validate_{{ $name }} = FormValidation.formValidation(form_{{ $name }}, {
        fields: validators_{{ $name }},
        plugins: {
            trigger: new FormValidation.plugins.Trigger(),
            bootstrap: new FormValidation.plugins.Bootstrap(),
            submitButton: new FormValidation.plugins.SubmitButton(),
        }
    })

    button_{{ $name }}.addEventListener("click", (function(n) {
        n.preventDefault(), validate_{{ $name }}.validate().then((function(validate) {
            if ("Valid" == validate) {
                button_{{ $name }}.innerHTML = 'Please wait...'
                button_{{ $name }}.disabled = true
                form_{{ $name }}.submit()
            } else {
                Swal.fire({
                    text: "Sorry, looks like there are some errors detected, please try again.",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                })
            }
        }))
    }))
</script>
