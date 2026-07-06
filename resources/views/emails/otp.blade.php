<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kode Verifikasi OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #F8FAFC; margin: 0; padding: 40px 0;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 16px; padding: 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <div style="width: 56px; height: 56px; background-color: #EAB308; border-radius: 12px; display: inline-block; line-height: 56px; font-weight: bold; font-size: 24px; color: #0F172A;">S</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <h2 style="color: #111827; margin: 0 0 8px 0;">Verifikasi Email Anda</h2>
                            <p style="color: #6B7280; font-size: 14px; margin: 0 0 24px 0;">
                                Halo {{ $user->name ?? 'Pengguna' }}, gunakan kode di bawah ini untuk memverifikasi akun SIGER-Hub Anda.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <div style="display: inline-block; background-color: #F9FAFB; border: 1px solid #E5E7EB; border-radius: 12px; padding: 16px 32px; font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #111827;">
                                {{ $otpCode }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <p style="color: #9CA3AF; font-size: 12px; margin: 0;">
                                Kode ini berlaku selama 10 menit. Jangan bagikan kode ini kepada siapapun, termasuk pihak yang mengaku dari SIGER-Hub.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>