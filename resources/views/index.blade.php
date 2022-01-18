<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <link href="{{ asset('images/favicon.png') }}" rel="icon" />
    <title>LifeRaft</title>
    <meta name="description" content="LifeRaft Code Challenge">
    <meta name="author" content="github.com/elmage">

    <script>
        window.Laravel = {csrfToken: '{{ csrf_token() }}'}
    </script>

    <!-- Web Fonts
    ======================== -->
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900' type='text/css'>

    <!-- Stylesheet
    ======================== -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" />
</head>
<body>


<!-- Document Wrapper
=============================== -->
<div id="main-wrapper">
    <page-component></page-component>
</div>
<!-- Document Wrapper End -->


<!-- Script -->
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
