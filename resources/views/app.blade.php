<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">    
</head>
<body>
    <div id="app">
        <app></app>
    </div>
</body>
<script src="{{ 'https://maps.googleapis.com/maps/api/js?key=' . env('GOOGLE_MAP_PLACES') . '&libraries=places' }}"></script>
<script src="{{ asset('js/daypilot-all.min.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
</html>