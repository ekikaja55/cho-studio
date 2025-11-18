<div
    style="background: #efeae4; max-width: 600px; margin: 32px auto; font-family: 'Hammersmith One', sans-serif; box-shadow: 0 2px 12px #a2e1db33; border-radius: 12px; overflow: hidden;">

    {{-- Header Section --}}
    <div
        style="background: linear-gradient(90deg, #7dc8c1 0%, #a2e1db 100%); padding: 24px 32px 32px 32px; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: bold; color: #444; margin-bottom: 8px;">Order Confirmed! Payment
            Required</h2>
        <p style="font-size: 1.1rem; color: #444; margin-bottom: 0;">Hi <span
                style="color: #444; font-weight: bold;">{{ $adoption->buyer_name }}</span>, your adoption is secured.</p>
    </div>

    <div style="padding: 24px 32px 32px 32px;">
        <p style="font-size: 1.05rem; color: #444; margin-bottom: 24px; text-align: center;">
            Great news! <strong>Cho.lazey</strong> has <strong>confirmed your adoption</strong> of the artwork
            <strong>"{{ $adoption->gallery->title }}"</strong>. Please follow the payment instructions below to finalize your
            purchase.
        </p>

        {{-- --- Order and Artwork Summary --- --}}
        <div
            style="background: #ffffff; border-radius: 8px; padding: 16px; margin-bottom: 24px; border: 1px solid #ddd;">
            <h3
                style="font-size: 1.25rem; color: #7dc8c1; margin-top: 0; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 6px;">
                Adoption Details</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.95rem; color: #444;">
                <tr>
                    <td style="padding: 6px 0; width: 40%; font-weight: 600;">Artwork:</td>
                    <td style="padding: 6px 0; text-align: right;">{{ $adoption->gallery->title }}</td>
                </tr>
                <tr>
                    <td style="padding: 6px 0; font-weight: 600;">Adoption ID:</td>
                    <td style="padding: 6px 0; text-align: right;">#{{ $adoption->adoption_id }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px 0; font-weight: 800; color: #444; border-top: 1px dashed #ddd;">TOTAL DUE:
                    </td>
                    <td style="padding: 8px 0; text-align: right; font-size: 1.2rem; font-weight: 800; color: #d65a5a;">
                        Rp{{ number_format($adoption->price, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>

        {{-- --- Payment Method: Bank Transfer --- --}}
        <div
            style="background: #a2e1db22; border-radius: 8px; padding: 18px; margin-bottom: 24px; border: 1px solid #a2e1db;">
            <h3
                style="font-size: 1.1rem; color: #7dc8c1; margin-top: 0; margin-bottom: 12px; font-weight: bold; text-align: center;">
                BANK TRANSFER DETAILS</h3>
            <div style="background: #ffffff; border-radius: 6px; padding: 12px;">
                <table style="width: 100%; border-collapse: collapse; font-size: 1rem; color: #444;">
                    <tr>
                        <td style="padding: 4px 0; width: 40%; font-weight: 600;">Bank Name:</td>
                        <td style="padding: 4px 0; text-align: right; font-weight: bold;">BCA</td> {{-- Placeholder: Replace with actual Bank Name --}}
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-weight: 600;">Account Name:</td>
                        <td style="padding: 4px 0; text-align: right; font-weight: bold;">[Artist's Full Name]</td>
                        {{-- Placeholder --}}
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; font-weight: 600;">Account Number:</td>
                        <td style="padding: 4px 0; text-align: right; font-weight: bold; color: #d65a5a;">123-456-7890
                        </td> {{-- Placeholder: Replace with actual Account Number --}}
                    </tr>
                </table>
            </div>
            <p style="font-size: 0.85rem; color: #555; margin-top: 12px; text-align: center;">
                Please transfer the exact amount of <strong>Rp{{ number_format($adoption->price, 0, ',', '.') }}</strong> to the
                account above.
            </p>
        </div>


        {{-- --- Payment Proof Procedure --- --}}
        <h3 style="font-size: 1.25rem; color: #7dc8c1; margin-bottom: 12px; margin-top: 0;">Payment Procedure</h3>
        <ol style="font-size: 1rem; color: #444; padding-left: 20px; margin-top: 0;">
            <li style="margin-bottom: 10px;">
                Complete the bank transfer for <strong>Rp{{ number_format($adoption->price, 0, ',', '.') }}</strong> to the provided
                account details.
            </li>
            <li style="margin-bottom: 10px;">
                Take a clear screenshot or photo of the <strong>payment receipt/proof of transfer</strong>.
            </li>
            <li style="margin-bottom: 10px;">
                <strong>Reply to this email</strong> with the payment proof attached (JPEG or PDF format preferred).
            </li>
            <li style="margin-bottom: 10px;">
                Once the artist verifies the transfer, your <strong>payment status will be updated to 'Paid'</strong>, and the
                delivery process will begin!
            </li>
        </ol>

        <p style="font-size: 0.95rem; color: #d65a5a; font-weight: bold; margin-top: 24px; text-align: center;">
            Please complete the payment within 24 hours to secure your artwork.
        </p>

        {{-- --- Footer Section --- --}}
        <div style="margin-top: 30px; text-align: center;">
            <p style="font-size: 1rem; color: #444">If you have any questions, just reply to this email, and we'll be
                happy to assist you.<br>Thank you for supporting Cho.lazey!</p>
            <hr style="margin: 18px 0; border: none; border-top: 1px solid #ddd;">
            <p style="font-size: 0.95rem; color: #444;">&copy; {{ date('Y') }} CHO Studio</p>
        </div>
    </div>
</div>
