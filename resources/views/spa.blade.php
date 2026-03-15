<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <title>Muy Humano - Gestión de Talento</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('vendors/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/ionicons-npm/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/linearicons-master/dist/web-font/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/pixeden-stroke-7-icon-master/pe-icon-7-stroke/dist/pe-icon-7-stroke.css') }}">
    <link href="{{ asset('css/base.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom-cntk.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    @vite('resources/css/app.css')
    @cloudinaryJS
</head>
<body>
    <div id="app"></div>

    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendors/moment/moment.js') }}"></script>
    <script src="{{ asset('vendors/metismenu/dist/metisMenu.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap4-toggle/js/bootstrap4-toggle.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery-circle-progress/dist/circle-progress.min.js') }}"></script>
    <script src="{{ asset('vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('vendors/toastr/build/toastr.min.js') }}"></script>
    <script src="{{ asset('vendors/jquery.fancytree/dist/jquery.fancytree-all-deps.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap-table/dist/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('vendors/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendors/@atomaras/bootstrap-multiselect/dist/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('vendors/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <script src="{{ asset('js/circle-progress.js') }}"></script>
    <script src="{{ asset('js/demo.js') }}"></script>
    <script src="{{ asset('js/scrollbar.js') }}"></script>
    <script src="{{ asset('js/toastr.js') }}"></script>
    <script src="{{ asset('js/treeview.js') }}"></script>
    <script src="{{ asset('js/form-components/toggle-switch.js') }}"></script>
    <script src="{{ asset('js/form-components/input-select.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    @vite('resources/js/app.js')
</body>
</html>
