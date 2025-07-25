<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>@yield('title', config('app.name', 'Laravel') | config('app.name', 'Laravel'))</title>
    <!-- Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="{{ asset('assets/sb2/css/styles.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/sb2/css/virtual-select.min.css') }}" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/sb2/assets/img/favicon.png') }}" />
    <!-- intl-tel-input CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css" />
    <link rel="stylesheet" href="{{ asset('assets/sb2/css/custom.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>


    {{-- <link  href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/css/bootstrap.min.css" rel="stylesheet">" --}}
    <link href="https://cdn.datatables.net/2.3.2/css/dataTables.bootstrap5.css" rel="stylesheet">"

    <link href="https://cdn.jsdelivr.net/npm/litepicker@2.0.12/dist/css/litepicker.css" rel="stylesheet">



    <style>
        .vscomp-option.disabled {
            display: none !important;
        }

        .decorationA {
            text-decoration: none !important;
        }



        label.error {
            color: red !important;
            font-size: 0.8rem !important;
            line-height: 1.2;
            margin-top: 0.25rem;
            display: block;
            position: relative;
            text-align: left !important;
        }


        input.error {
            border: 1px solid red !important;
        }

        textarea.error {
            border: 1px solid red;
        }

        select.error {
            border: 1px solid red;
        }

        input.error::focus {
            border: 1px solid red !important;
        }

        textarea.error::focus {
            border: 1px solid red;
        }

        select.error::focus {
            border: 1px solid red;
        }

        div.vscomp-wrapper.focused .vscomp-toggle-button,
        div.vscomp-wrapper:focus .vscomp-toggle-button {
            box-shadow: none;
        }

        div.vscomp-toggle-button {
            width: 100%;
            height: calc(1.5em + .75rem + 7px);
            padding: .375rem .75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #6e707e;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        div.vscomp-ele {
            max-width: 100%;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

        table#dataTable a:hover {
            text-decoration: none;
        }

    </style>



    <!-- Allow child views to add CSS -->
    @stack('css')
</head>

<body class="nav-fixed">
    @include('layouts.partials.sb2.navbar')
    <div id="layoutSidenav">
        {{-- @include('layouts.partials.sb2.sidebar') --}}


        @php
        $role = Auth::user()->role;
        @endphp

        @if($role === 'admin' || $role === 'super-admin')
        @include('layouts.partials.sb2.sidebar')
        @elseif($role === 'sales')
        @include('layouts.partials.sb2.sales')
        @elseif($role === 'services')
        @include('layouts.partials.sb2.services')
        @endif



        <div id="layoutSidenav_content">
            @yield('content')
            @include('layouts.partials.sb2.footer')
        </div>
    </div>

    <!-- Core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
    {{-- <script src="{{ asset('assets/sb2/assets/demo/chart-area-demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/sb2/assets/demo/chart-bar-demo.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/sb2/js/datatables/datatables-simple-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/sb2/js/litepicker.js') }}"></script>
    {{-- <script src="{{ asset('assets/sb2/js/custom/form.js') }}"></script> --}}
    <script src="{{ asset('assets/sb2/js/custom/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/litepicker@2.0.12/dist/litepicker.js"></script>

    <!-- intl-tel-input JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/sb2/js/virtual-select.min.js') }}"></script>
    <script src="{{ asset('assets/sb2/js/jquery.validate.min.js') }}"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.3.2/js/dataTables.bootstrap5.js"></script>

    <script src="{{ asset('assets/sb2/js/formjs.js') }}"></script>
    <script src="{{ asset('assets/sb2/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/sb2/js/functions.js') }}"></script>
    <script>
        feather.replace();
        
    </script>

    <!-- Toast container -->
    <div style="position: fixed; bottom: 1rem; right: 1rem; z-index: 9999;">
        <!-- ✅ Success Toast -->
        <div class="toast" id="successToster" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-primary text-white">
                <i data-feather="check-circle"></i>
                <strong id="successTitle" class="ms-2 me-auto">Success</strong>
                <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="successBody" class="toast-body">Success message here</div>
        </div>

        <!-- ❌ Danger Toast -->
        <div class="toast" id="dangerToster" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
            <div class="toast-header bg-danger text-white">
                <i data-feather="alert-circle"></i>
                <strong id="dangerTitle" class="ms-2 me-auto">Error</strong>
                <button class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div id="dangerBody" class="toast-body">Error message here</div>
        </div>
    </div>

    </div>

    <!-- Feather Icons -->
    <script>
        feather.replace();

    </script>

    <!-- Select2 Init -->

    <!-- Toast & Session Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successToast = new bootstrap.Toast(document.getElementById('successToster'));
            const dangerToast = new bootstrap.Toast(document.getElementById('dangerToster'));

            window.showSuccessToast = function(title = "Success", message) {
                document.getElementById('successTitle').textContent = title;
                document.getElementById('successBody').textContent = message;
                successToast.show();
            };

            window.showDangerToast = function(title = "Error", message) {
                document.getElementById('dangerTitle').textContent = title;
                document.getElementById('dangerBody').textContent = message;
                dangerToast.show();
            };

            @if(session('success'))
            showSuccessToast("Success!", @json(session('success')));
            @endif

            @if(session('error'))
            showDangerToast("Error!", @json(session('error')));
            @endif

            @if($errors->any())
            let errorMessages = {
                !!json_encode($errors - > all()) !!
            };
            let errorText = errorMessages.join("\n");
            showDangerToast("Validation Error", errorText);
            @endif
        });

    </script>
    <script>
        // window.baseUrl = '{{ asset('') }}';
        window.baseUrl = '{{ url(' / ') }}';
        String.prototype.limitWords = function(limit) {
            const words = this.split(' ');
            return words.length <= limit ? this.concat() : words.slice(0, limit).join(' ') + '...';
        };

        String.prototype.limitCharacter = function(maxLength) {
            return this.length > maxLength ?
                this.substring(0, maxLength) + '...' :
                this;
        };

        String.prototype.toConvertDatetime = function(format = 'D M, Y') {
            const date = new Date(this);

            if (isNaN(date.getTime())) {
                return this; // Invalid date, return original string
            }

            const map = {
                D: date.toLocaleString('en-US', {
                    weekday: 'short'
                }), // Mon
                M: date.toLocaleString('en-US', {
                    month: 'short'
                }), // May
                Y: date.getFullYear(), // 2025
                d: String(date.getDate()).padStart(2, '0'), // 15
                H: String(date.getHours()).padStart(2, '0'), // 14
                i: String(date.getMinutes()).padStart(2, '0'), // 30
                s: String(date.getSeconds()).padStart(2, '0') // 45
            };

            return format.replace(/D|M|Y|d|H|i|s/g, match => map[match]);
        };

    </script>

    @stack('scripts')
</body>

</html>
