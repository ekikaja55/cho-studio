@extends('template')

@section('content')
    {{-- Latar belakang utama --}}
    <div class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start font-[HammersmithOne-Regular]">
        @include('gallery.showcase')
        @include('gallery.ready_design')
        @include('gallery.purchase_modal')
        @include('gallery.preview_modal')
    </div>
    <style>
        /* overlay shown when image fails to load */
        .broken-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            background: rgba(243, 244, 246, 0.75);
            font-weight: 600;
            font-size: 0.9rem;
            pointer-events: none;
            border-radius: inherit;
            text-transform: none;
        }

        /* Gallery showcase enhancements */
        #galleryShowcaseCustom {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth transitions for gallery items */
        #galleryShowcaseCustom img {
            transition: opacity 0.3s ease-in-out, brightness 0.3s ease-in-out;
        }

        .showcase-item,
        .design-item {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }

        /* Design grid scrollbar styling */
        #designGrid {
            scrollbar-width: thin;
            scrollbar-color: rgba(162, 225, 219, 0.6) rgba(0, 0, 0, 0.05);
            perspective: 1000px;
            will-change: scroll-position;
        }

        #designGrid::-webkit-scrollbar {
            width: 6px;
        }

        #designGrid::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        #designGrid::-webkit-scrollbar-thumb {
            background: rgba(162, 225, 219, 0.6);
            border-radius: 10px;
        }

        #designGrid::-webkit-scrollbar-thumb:hover {
            background: rgba(162, 225, 219, 0.9);
        }

        /* Prevent scale from causing overflow */
        .design-item {
            transform-origin: center;
            backface-visibility: hidden;
        }

        /* Smooth line clamp */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Enhanced responsive design cards */
        @media (max-width: 1024px) {
            #previewPanel {
                width: 100%;
            }
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            #designGrid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.75rem;
            }

            .showcase-item {
                border-radius: 0.75rem;
            }
        }
    </style>
@endsection

@section('scripts')
    @vite(['resources/js/gallery.js'])
@endsection

@section('disableinspect')
    <script>
        (function() {
            // disable right-click
            document.addEventListener('contextmenu', e => e.preventDefault());

            // disable common DevTools shortcuts (best-effort)
            document.addEventListener('keydown', function(e) {
                const k = e.key || e.keyIdentifier || e.keyCode;
                const key = (typeof k === 'string') ? k.toUpperCase() : k;

                // F12
                if (key === 'F12' || key === 123) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                // Ctrl+U (view source), Ctrl+Shift+I/J/C/K (DevTools), Ctrl+Shift+C
                if (e.ctrlKey && (e.key && ['U'].includes(e.key.toUpperCase()))) {
                    e.preventDefault();
                    e.stopPropagation();
                }
                if (e.ctrlKey && e.shiftKey && e.key && ['I', 'J', 'C', 'K'].includes(e.key.toUpperCase())) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        })();
    </script>
@endsection
