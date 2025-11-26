@php
    // Helper values and safe fallbacks
    $gallery = $adoption->gallery ?? null;
    $galleryId = $gallery->gallery_id ?? ($adoption->gallery_id ?? '-');
    $galleryTitle = $gallery->title ?? '-';
    $galleryPrice = $gallery->price ?? null;
    $buyerEmail = $adoption->email ?? '-';
    $adoptionId = $adoption->adoption_id ?? ($adoption->{$adoption->getKeyName()} ?? '-');
    $orderStatus = strtoupper($adoption->order_status ?? '-');
    $paymentStatus = strtoupper($adoption->payment_status ?? '-');
@endphp

<div style="background: #efeae4; max-width: 640px; margin: 28px auto; font-family: 'Poppins', Arial, sans-serif; box-shadow: 0 6px 18px rgba(0,0,0,0.06); border-radius:12px; overflow:hidden;">
    <div style="background: linear-gradient(90deg, #a2e1db 0%, #7dc8c1 100%); padding:22px 24px; text-align:center; color:#fff;">
        <h1 style="margin:0; font-size:20px; font-weight:700;">Thanks — We received your adoption request</h1>
        <p style="margin:6px 0 0 0; opacity:0.95; font-size:13px;">We'll verify your payment and follow up by email.</p>
    </div>

    <div style="background:#fff; padding:20px 22px; border-bottom:1px solid #f0f0f0;">
        <p style="margin:0 0 12px 0;">Hi <strong style="color:#333;">{{ $buyerEmail }}</strong>,</p>
        <p style="margin:0 0 14px 0; color:#444;">Thanks for supporting c. Your adoption has been recorded — details below.</p>

        <div style="display:flex; gap:14px; flex-wrap:wrap; margin-top:14px;">
            <div style="flex:1; min-width:220px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
                <div style="font-size:13px; color:#7a6c5f; font-weight:600;">Adoption ID</div>
                <div style="font-weight:700; margin-top:6px;">#{{ $adoptionId }}</div>
            </div>
            <div style="flex:1; min-width:220px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
                <div style="font-size:13px; color:#7a6c5f; font-weight:600;">Order Status</div>
                <div style="font-weight:700; margin-top:6px;">{{ $orderStatus }}</div>
            </div>
            <div style="flex:1; min-width:220px; background:#fafaf9; padding:12px; border-radius:8px; border:1px solid #f0f0f0;">
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
        <p style="margin:6px 0;">We will review the payment proof and update the order status. Typical verification time: <strong>up to 24 hours</strong>.</p>
        <p style="margin:6px 0;">If you have questions, reply to this email or contact <a href="mailto:support@chostudio.com">support@chostudio.com</a>.</p>
        <p style="margin:10px 0 0 0; font-size:12px; color:#999;">© {{ date('Y') }} CHO Studio</p>
    </div>
</div>
