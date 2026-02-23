<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? 'Page title' }}</title>
@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    [x-cloak] {
        display: none !important;
    }
</style>
