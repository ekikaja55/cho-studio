@php
    // Default config
    $colors = [
        'success' => ['start' => '#a2e1db', 'end' => '#7dc8c1', 'icon' => '✓'], // Mint (Default)
        'error'   => ['start' => '#e1a2a2', 'end' => '#c87d7d', 'icon' => '✕'], // Merah
        'info'    => ['start' => '#a2cfe1', 'end' => '#7db5c8', 'icon' => 'ℹ'], // Biru
    ];

    $type = $data['type'] ?? 'success';
    $theme = $colors[$type] ?? $colors['success'];
@endphp

<div style="background: #efeae4; max-width: 640px; margin: 28px auto; font-family: 'Poppins', Arial, sans-serif; box-shadow: 0 6px 18px rgba(0,0,0,0.06); border-radius:12px; overflow:hidden;">
    
    {{-- Header Dinamis --}}
    <div style="background: linear-gradient(90deg, {{ $theme['start'] }} 0%, {{ $theme['end'] }} 100%); padding:24px; text-align:center; color:#fff;">
        <div style="font-size:32px; margin-bottom:8px; line-height:1;">{{ $theme['icon'] }}</div>
        <h1 style="margin:0; font-size:22px; font-weight:700;">{{ $data['headline'] }}</h1>
    </div>

    <div style="background:#fff; padding:24px 28px; border-bottom:1px solid #f0f0f0;">
        {{-- Pesan Utama --}}
        <p style="margin:0 0 16px 0; font-size:15px; line-height:1.6; color:#444;">
            {!! $data['message'] !!}
        </p>

        {{-- Tabel Detail Dinamis --}}
        @if(!empty($data['details']))
        <div style="background:#fafaf9; border:1px solid #f0f0f0; border-radius:8px; padding:16px; margin:20px 0;">
            <table style="width:100%; border-collapse:collapse;">
                @foreach($data['details'] as $label => $value)
                <tr>
                    <td style="padding:6px 0; font-size:12px; color:#888; text-transform:uppercase; width:40%;">{{ $label }}</td>
                    <td style="padding:6px 0; font-size:14px; font-weight:600; color:#333; text-align:right;">{{ $value }}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endif

        {{-- Gambar (Opsional, misal untuk Adoption/Commission Progress) --}}
        @if(!empty($data['image_url']))
        <div style="margin:20px 0; text-align:center;">
            <p style="font-size:12px; color:#999; margin-bottom:5px;">Preview:</p>
            <img src="{{ $data['image_url'] }}" style="max-width:100%; border-radius:8px; border:1px solid #eee;">
        </div>
        @endif

        {{-- Tombol Aksi --}}
        @if(!empty($data['action_url']))
        <div style="margin-top:28px; text-align:center;">
            <a href="{{ $data['action_url'] }}" style="background:#333; color:#fff; text-decoration:none; padding:12px 24px; border-radius:50px; font-size:14px; font-weight:600; display:inline-block;">
                {{ $data['action_text'] ?? 'View Details' }}
            </a>
        </div>
        @endif
    </div>

    {{-- Footer --}}
    <div style="background:#faf7f2; padding:16px 22px; text-align:center; color:#8c8680; font-size:12px; border-top:1px solid #eee;">
        <p style="margin:0;">© {{ date('Y') }} CHO Studio. All rights reserved.</p>
    </div>
</div>