<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP AKSARA</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f1f5f9; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 24px rgba(0,0,0,0.08); }
        .header { background: #0F172A; padding: 32px 40px; text-align: center; }
        .header h1 { color: #EAB308; margin: 0; font-size: 24px; font-weight: 700; }
        .header p { color: #94A3B8; margin: 4px 0 0; font-size: 13px; }
        .body { padding: 40px; }
        .greeting { color: #1e293b; font-size: 16px; margin-bottom: 16px; }
        .otp-box { background: #f8fafc; border: 2px dashed #EAB308; border-radius: 12px; padding: 24px; text-align: center; margin: 24px 0; }
        .otp-code { font-size: 40px; font-weight: 900; letter-spacing: 12px; color: #0F172A; font-family: monospace; }
        .otp-label { color: #64748b; font-size: 12px; margin-top: 8px; }
        .info { color: #475569; font-size: 14px; line-height: 1.6; }
        .warning { background: #fef3c7; border-left: 4px solid #EAB308; padding: 12px 16px; border-radius: 0 8px 8px 0; color: #92400e; font-size: 13px; margin-top: 20px; }
        .footer { background: #f8fafc; padding: 20px 40px; text-align: center; color: #94A3B8; font-size: 12px; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>AKSARA</h1>
            <p>Diskominfotik Provinsi Lampung</p>
        </div>
        <div class="body">
            <p class="greeting">Halo, <strong>{{ $user->name }}</strong>!</p>
            <p class="info">Gunakan kode OTP berikut untuk memverifikasi akun Anda:</p>

            <div class="otp-box">
                <div class="otp-code">{{ $otpCode }}</div>
                <div class="otp-label">Kode berlaku selama <strong>10 menit</strong></div>
            </div>

            <p class="info">Jangan bagikan kode ini kepada siapapun, termasuk petugas AKSARA.</p>

            <div class="warning">
                ⚠️ Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini dan segera hubungi administrator.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Pemerintah Provinsi Lampung. Hak Cipta Dilindungi.
        </div>
    </div>
</body>
</html>