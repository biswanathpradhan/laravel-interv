<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Prize distrubtion')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <style>
        body {
            padding-top: 80px;
        }

        footer {
            padding: 20px 0;
            background-color: #f5f5f5;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

    .txt-clr{
        text-align: center;
        color: #720a31 !important;
    }
    </style>
</head>

<body>



    <!-- Main Content -->
    <div class="container">
        @yield('content')
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js'></script>
    @stack('scripts')
</body>

</html>
