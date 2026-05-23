<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cho's Studio</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('assets/css/background.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- icon: font awesome --}}
    <script src="https://kit.fontawesome.com/2773bd903f.js" crossorigin="anonymous"></script>

    {{-- Flowbite JS for drawer/modal components --}}
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <style>
        body {
            -webkit-user-select: none;
            /* Chrome/Safari */
            -moz-user-select: none;
            /* Firefox */
            -ms-user-select: none;
            /* IE10+ */
            user-select: none;
            /* Standard */
            transition: filter 0.3s ease;
        }

        img {
            /* Mencegah gambar di-drag */
            -webkit-user-drag: none;
            -khtml-user-drag: none;
            -moz-user-drag: none;
            -o-user-drag: none;
            /* Mencegah menu touch hold di HP */
            -webkit-touch-callout: none;
        }
    </style>
</head>

<body class="h-full flex flex-col overflow-hidden">
    @include('member.navbar')

    <main class="flex-1 overflow-y-auto">
        @yield('content')
    </main>

    @yield('scripts')
    <script>
        (function () {
            // 1. Disable Right Click
            document.addEventListener('contextmenu', e => e.preventDefault());

            // 2. Disable Dragging Gambar secara Global
            document.addEventListener('dragstart', function (e) {
                e.preventDefault();
            });

            // 3. Disable Keyboard Shortcuts (Inspect & PrintScreen)
            document.addEventListener('keydown', function (e) {
                const k = e.key || e.keyCode;

                // Disable F12
                if (k === 'F12' || k === 123) {e.preventDefault();}

                // Disable Ctrl+Shift+I/J/C (Inspect)
                if (e.ctrlKey && e.shiftKey && ['I', 'J', 'C'].includes(e.key.toUpperCase())) {
                    e.preventDefault();
                }

                // Disable Ctrl+U (View Source)
                if (e.ctrlKey && e.key.toUpperCase() === 'U') {e.preventDefault();}

                // Disable Ctrl+S (Save Page)
                if (e.ctrlKey && e.key.toUpperCase() === 'S') {
                    e.preventDefault();
                    alert('Saving this page is disabled to protect intellectual property.');
                }

                // Disable PrintScreen (Hanya bekerja di beberapa browser/OS, tidak semua)
                if (k === 'PrintScreen' || k === 44) {
                    // Kita sembunyikan body sebentar saat tombol ditekan
                    document.body.style.visibility = 'hidden';
                    navigator.clipboard.writeText('Screenshots are disabled!'); // Timpa clipboard
                    alert('Screenshots are disabled on this site.');

                    setTimeout(() => {
                        document.body.style.visibility = 'visible';
                    }, 1000);
                }
            });

            // 4. Blur Screen saat user pindah tab/window (Anti Snipping Tool)
            {
                {--window.addEventListener('blur', () => {--}}
                {{--document.body.style.filter = 'blur(20px)'; --} }
                {{--}); --}
            }
            {{----} }
            {
                {--window.addEventListener('focus', () => {--}}
                {{--document.body.style.filter = 'none'; --} }
                {{--}); --}
            }
            {{----} }
        })();

    </script>
</body>

</html>
