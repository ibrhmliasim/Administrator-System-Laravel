<!-- C:\Users\Asim\sekkeiShoLrvl\resources\views\layouts\app.blade.php -->

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel Task</title>

        {{-- Tailwind / assets --}}
        @vite([
            'resources/css/app.css', 
            'resources/css/style.css', 
            'resources/js/app.js'
        ])
    </head>

    <body class="bg-gray-100 text-gray-700">
        
        <main class="container-wrap my-6 mx-6 md:mx-12">
            @yield('searchPage')
            @yield('registPage')
            @yield('editPage')
        </main>

        {{-- bladeページからのスクリプトはここにあります --}}
            @stack('scripts')
    </body>
</html>
