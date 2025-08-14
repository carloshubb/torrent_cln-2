<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>


    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    @endphp
    
    @if(isset($manifest['resources/css/app.css']))
        <link rel="stylesheet" href="{{ asset('build/' . $manifest['resources/css/app.css']['file']) }}">
    @endif
    
    <script type="module" src="{{ asset('build/' . $manifest['resources/js/app.js']['file']) }}"></script>

    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>