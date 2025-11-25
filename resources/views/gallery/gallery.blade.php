@extends('template')

@section('content')
    <style>
        .custom-swal-popup {
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-title {
            font-size: 24px;
            font-weight: bold;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

        .custom-swal-text {
            font-size: 16px;
            font-family: 'HammersmithOne-Regular', sans-serif;
        }

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

        body {
            -webkit-user-select: none; /* Chrome/Safari */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* IE10+ */
            user-select: none; /* Standard */
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
    

        .protected-image-container {
            position: relative;
            display: inline-block;
            overflow: hidden;
            width: 100%;
            height: 100%;
        }

        /* Watermarknya */
        .protected-image-container::after {
            content: "CHO'S STUDIO - PREVIEW ONLY"; /* Teks Watermark */
            position: absolute;
            top: 20%;      /* Taruh titik acuan di tengah vertikal */
            left: 18%;     /* Taruh titik acuan di tengah horizontal */
            transform: translate(-50%, -50%) rotate(-45deg);  /* Miring 45 derajat */
            font-size: 1.5rem; /* Sesuaikan besar kecilnya */
            font-weight: bold;
            color: rgba(255, 255, 255, 0.5); /* Putih transparan */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7); /* Bayangan hitam biar terbaca di gambar terang */
            white-space: nowrap;
            pointer-events: none; /* Supaya klik tembus ke gambar */
            z-index: 10;
            width: 100%;
            text-align: center;
        }

        /* Opsi Watermark Berulang (Tiled) - Lebih Aman */
        .watermark-tiled::after {
            content: "CHO'S STUDIO  CHO'S STUDIO  CHO'S STUDIO  CHO'S STUDIO";
            font-size: 1rem;
            line-height: 0rem; /* Jarak antar baris */
            white-space: pre-wrap; /* Biar bisa banyak baris */
            text-align: justify;
            opacity: 0.3;
            transform: rotate(-30deg) scale(1.5);
        }
    </style>

    {{-- Latar belakang utama --}}
    <div class="min-h-screen p-2 sm:p-4 mt-4 sm:mt-8 flex justify-center items-start font-[HammersmithOne-Regular]">
        @include('gallery.showcase')
        @include('gallery.ready_design')
        @include('gallery.purchase_modal')
        @include('gallery.preview_modal')
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/gallery.js'])
@endsection
