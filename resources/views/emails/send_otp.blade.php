<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .header { text-align: center; color: #0f8b6d; font-size: 24px; font-weight: bold; margin-bottom: 20px; }
        .otp-box { background: #e1f5ee; border: 2px dashed #0f8b6d; padding: 15px; text-align: center; font-size: 32px; font-weight: bold; color: #0f6e56; letter-spacing: 5px; margin: 20px 0; border-radius: 8px; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; border-top: 1px solid #eee; padding-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">DKM Masjid Al-Musabaqoh</div>
        <p>Halo,</p>
        <p>Kami menerima permintaan untuk mereset password akun admin Anda. Silakan gunakan kode OTP berikut untuk melanjutkan proses reset password:</p>
        
        <div class="otp-box">
            {{ $otp }}
        </div>
        
        <p><em>Kode ini hanya berlaku selama 15 menit. Jika Anda tidak merasa meminta reset password, abaikan saja email ini.</em></p>
        
        <div class="footer">
            &copy; {{ date('Y') }} Sistem Informasi DKM Masjid Al-Musabaqoh.<br>
            Email ini dibuat otomatis, mohon tidak membalas.
        </div>
    </div>
</body>
</html>