
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
<title>{{ !empty($settings?->seo_title) ? $settings->seo_title : ($settings->brand_name ?? 'Website') }}</title>
<meta
    name="description"
    content="{{ $settings->seo_description ?? '' }}"
>

@if (!empty($settings->favicon_path))
    <link
        rel="icon"
        href="{{ asset('storage/' . $settings->favicon_path) }}"
    >
@endif

    @viteReactRefresh
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

</head>
<body>
    <div id="app"></div>
</body>
</html>
