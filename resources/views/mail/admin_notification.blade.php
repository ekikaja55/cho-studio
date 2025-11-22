@php
    $gallery = $adoption->gallery ?? null;
    $galleryId = $gallery->gallery_id ?? ($adoption->gallery_id ?? '-');
    $galleryTitle = $gallery->title ?? '-';
    $galleryPrice = $gallery->price ?? 0;
    $adoptionId = $adoption->adoption_id ?? ($adoption->{$adoption->getKeyName()} ?? '-');
    $buyerEmail = $adoption->email ?? '-';
    $orderStatus = strtoupper($adoption->order_status ?? '-');
    $paymentStatus = strtoupper($adoption->payment_status ?? '-');
@endphp

<div style="background: #efeae4; max-width: 640px; margin: 28px auto; font-family: 'Poppins', Arial, sans-serif; box-shadow: 0 6px 18px rgba(0,0,0,0.06); border-radius:12px; overflow:hidden;">
    <div style="background: linear-gradient(90deg, #a2e1db 0%, #7dc8c1 100%); padding:22px 24px; text-align:center; color:#fff;">
        <h1 style="margin:0; font-size:20px; font-weight:700;">🧾 New Adoption Received</h1>
        <p style="margin:6px 0 0; font-size:13px; opacity:0.95;">A new adoption has been submitted — please review below.</p>
    </div>

    <div style="background:#fff; padding:20px 22px; border-bottom:1px solid #f0f0f0;">
        <p style="margin:0 0 12px 0;">Hi <strong style="color:#333;">Cho.Lazey</strong>,</p>
        <p style="margin:0 0 14px 0; color:#444;">A new adoption request has been received. Details are provided below for your review.</p>

        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-top:14px;">
            <div style="flex:1; min-width:180px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
                <div style="font-size:13px; color:#7a6c5f; font-weight:600;">Adoption ID</div>
                <div style="font-weight:700; margin-top:6px;">#{{ $adoptionId }}</div>
            </div>
            <div style="flex:1; min-width:180px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
                <div style="font-size:13px; color:#7a6c5f; font-weight:600;">Buyer Email</div>
                <div style="font-weight:700; margin-top:6px;">{{ $buyerEmail }}</div>
            </div>
            <div style="flex:1; min-width:180px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
                <div style="font-size:13px; color:#7a6c5f; font-weight:600;">Payment Status</div>
                <div style="font-weight:700; margin-top:6px;">{{ $paymentStatus }}</div>
            </div>
        </div>

        <hr style="border:none; border-top:1px solid #f4f4f4; margin:18px 0;">

        <h3 style="margin:0 0 8px 0; color:#7dc8c1;">Artwork</h3>
        <table style="width:100%; font-size:14px; color:#444; border-collapse:collapse;">
            <tr>
                <td style="padding:6px 0; color:#7a6c5f; font-weight:600; width:40%;">Gallery ID</td>
                <td style="text-align:right;">#{{ $galleryId }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#7a6c5f; font-weight:600;">Title</td>
                <td style="text-align:right;">{{ $galleryTitle }}</td>
            </tr>
            <tr>
                <td style="padding:6px 0; color:#7a6c5f; font-weight:600;">Price</td>
                <td style="text-align:right; font-weight:700; color:#d65a5a;">Rp{{ number_format($galleryPrice ?? 0, 0, ',', '.') }}</td>
            </tr>
        </table>

    </div>

    <div style="background:#faf7f2; padding:16px 22px; text-align:center; color:#6f6b66; font-size:13px;">
        <p style="margin:6px 0;">Open the dashboard to verify payment and update order status.</p>
        <p style="margin:6px 0;"><a href="{{ url('/artist/adoptions') }}" style="display:inline-block; padding:10px 18px; background:#7dc8c1; color:#fff; border-radius:8px; text-decoration:none;">View in Dashboard</a></p>
        <p style="margin:10px 0 0 0; font-size:12px; color:#999;">© {{ date('Y') }} CHO Studio</p>
    </div>
</div>
