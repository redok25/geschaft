{{--

    HOW TO USE

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
--}}

<div class="table-responsive">
    <table class="table table-striped" id="{{ $name }}-table">
        <thead>
            <tr>
                @foreach ($header as $d)
                    <th>{{ $d }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

@push('scripts')
    {{ $callback }}
    {{ $slot }}

    <script>
        $(document).ready(function() {
            let column_{{ $name }} = columns;
            let callback_{{ $name }} = () => callback();
            var table = $('#{{ $name }}-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ $url }}',
                columns: column_{{ $name }},
                drawCallback: function(settings) {
                    callback_{{ $name }}()
                }
            });
        });
    </script>
@endpush
