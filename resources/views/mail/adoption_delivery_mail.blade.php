<div
    style="background: #efeae4; max-width: 600px; margin: 32px auto; font-family: 'Hammersmith One', sans-serif; box-shadow: 0 2px 12px #a2e1db33;">
    <div
        style="background: linear-gradient(90deg, #a2e1db 0%, #7dc8c1 100%); padding: 16px 32px 32px 32px; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: bold; color: #444; margin-bottom: 8px;">Your Artwork Files Are
            Ready!</h2>
        <p style="font-size: 1.1rem; color: #444; margin-bottom: 0;">Hi <span
                style="color: #444; font-weight: bold;">{{ $adoption->email }}</span>,</p>
    </div>
    <div style="padding: 24px 32px 32px 32px;">
        <p style="font-size: 1.1rem; color: #444; margin-bottom: 18px; text-align: center;">
            Thank you for your adoption! The files for your artwork are now available for download below.
        </p>

        {{-- --- Order Summary Section --- --}}
        <div
            style="background: #ffffff; border-radius: 8px; padding: 16px; margin-bottom: 24px; border: 1px solid #ddd;">
            <h3
                style="font-size: 1.25rem; color: #7dc8c1; margin-top: 0; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                Order Summary</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; color: #444;">
                <tr>
                    <td style="padding: 4px 0; font-weight: 600;">Order Date:</td>
                    <td style="padding: 4px 0; text-align: right;">{{ $adoption->created_at->format('M d, Y') }}</td>
                </tr>
                @if(isset($adoption->gallery->price))
                <tr>
                    <td style="padding: 4px 0; font-weight: 600;">Total Paid:</td>
                    <td style="padding: 4px 0; text-align: right;">Rp{{ number_format($adoption->gallery->price, 0, ',', '.') }}
                    </td>
                </tr>
                @endif
            </table>
        </div>

        {{-- --- Artwork Details Section --- --}}
        @if ($adoption->gallery)
            <div
                style="background: #ffffff; border-radius: 8px; padding: 16px; margin-bottom: 24px; border: 1px solid #ddd;">
                <h3
                    style="font-size: 1.25rem; color: #7dc8c1; margin-top: 0; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                    Artwork Details</h3>
                <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; color: #444;">
                    <tr>
                        <td style="padding: 4px 0; width: 40%; font-weight: 600;">Title:</td>
                        <td style="padding: 4px 0; text-align: right;"><strong>{{ $adoption->gallery->title }}</strong></td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-weight: 600;">Original File Format:</td>
                        <td style="padding: 4px 0; text-align: right;">{{ $adoption->gallery->file_format }}</td>
                    </tr>
                </table>
            </div>
        @endif

            @php
                use Illuminate\Support\Str;
                $deliveryValue = $adoption->delivery_file ?? '';
                $deliveryType = $adoption->delivery_type ?? null;
                $hasDelivery = !empty($deliveryValue) || !empty($deliveryType);
                $isExternal = $hasDelivery && Str::startsWith($deliveryValue, ['http://', 'https://']);
                $downloadUrl = null;
                if ($hasDelivery) {
                    $downloadUrl = $isExternal ? $deliveryValue : (isset($adoption->adoption_id) ? route('adoption.download', $adoption->adoption_id) : null);
                }
            @endphp

            @if($hasDelivery)
                <div
                    style="background: #a2e1db22; border-radius: 12px; padding: 18px; text-align: center; margin-bottom: 18px; border: 1px solid #a2e1db;">
                    <span style="font-size: 1.1rem; color: #7dc8c1; font-weight: 600;">@if($isExternal) Access Your Download @else Access Your Artwork @endif</span><br>
                    @if($downloadUrl)
                        <a href="{{ $downloadUrl }}"
                            style="display: inline-block; margin: 8px; padding: 12px 30px; background: #7dc8c1; color: #fff; font-size: 1rem; font-weight: bold; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 8px #a2e1db66;"
                            @if ($isExternal) rel="noopener noreferrer" @endif>Download
                            <strong>{{ $adoption->gallery->title ?? 'your files' }}</strong></a>
                    @else
                        <p style="margin:12px 0; color:#444;">We have recorded your delivery request. You will receive a link here once the files are ready.</p>
                    @endif

                    <br>
                    <span style="font-size: 0.95rem; color: #444;">
                        @if($isExternal)
                            You will be redirected to an external hosting site to download the file.
                        @else
                            The file will be downloaded directly from Cho's Studio Website when available.
                        @endif
                    </span>
                </div>
            @endif

        <p style="font-size: 0.85rem; color: #666; margin-bottom: 18px; text-align: center;">
            If you have any trouble accessing or downloading your files, reply to this email or contact support at <a
                href="mailto:support@chostudio.com" style="color: #7dc8c1;">support@chostudio.com</a>.
        </p>


        <div style="margin-top: 24px; text-align: center;">
            <p style="font-size: 1rem; color: #444">Thank you for supporting <strong>Cho.lazey</strong>!</p>
            <hr style="margin: 18px 0; border: none; border-top: 1px solid #ddd;">
            <p style="font-size: 0.95rem; color: #444;">&copy; {{ date('Y') }} CHO Studio</p>
        </div>
    </div>
</div>
