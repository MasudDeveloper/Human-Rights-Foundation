<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সফটওয়্যার লাইসেন্স স্থগিত | 403 Forbidden - License Suspended</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Outfit:wght@400;600;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            background: radial-gradient(circle at 50% 30%, #450a0a 0%, #09090b 85%);
            color: #f1f5f9;
            font-family: 'Hind Siliguri', 'Outfit', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .lock-container {
            max-width: 680px;
            width: 100%;
            background: rgba(24, 10, 10, 0.9);
            border: 1px solid rgba(239, 68, 68, 0.45);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 42px 36px;
            box-shadow: 0 25px 60px -15px rgba(220, 38, 38, 0.35), 0 0 40px rgba(0, 0, 0, 0.8);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .lock-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 4px;
            background: linear-gradient(90deg, #dc2626, #f97316, #dc2626);
            animation: glow 3s linear infinite;
        }
        @keyframes glow {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }
        .shield-icon {
            width: 84px;
            height: 84px;
            margin: 0 auto 20px;
            background: rgba(220, 38, 38, 0.15);
            border: 2px solid rgba(220, 38, 38, 0.4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }
        .shield-icon svg { width: 46px; height: 46px; }
        .badge {
            display: inline-block;
            background: rgba(220, 38, 38, 0.2);
            color: #fca5a5;
            border: 1px solid rgba(220, 38, 38, 0.4);
            padding: 5px 16px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 14px;
        }
        h1 {
            font-size: 26px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
        }
        .subtitle {
            font-size: 15px;
            color: #cbd5e1;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .details-box {
            background: rgba(10, 5, 5, 0.8);
            border: 1px dashed rgba(239, 68, 68, 0.35);
            border-radius: 12px;
            padding: 16px 20px;
            text-align: left;
            margin-bottom: 24px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 13px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .detail-row:last-child { border-bottom: none; }
        .detail-label { color: #94a3b8; }
        .detail-val { color: #f87171; font-weight: 600; }
        .notice-box {
            font-size: 14px;
            color: #fecaca;
            line-height: 1.7;
            background: rgba(185, 28, 28, 0.15);
            border-left: 4px solid #ef4444;
            padding: 14px 18px;
            border-radius: 0 8px 8px 0;
            text-align: left;
            margin-bottom: 24px;
        }
        .contact-box {
            background: rgba(30, 41, 59, 0.5);
            border-radius: 10px;
            padding: 14px;
            font-size: 13px;
            color: #94a3b8;
            margin-bottom: 20px;
        }
        .contact-box strong { color: #fbbf24; }
        .footer-info {
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            padding-top: 16px;
        }
    </style>
</head>
<body>
    <div class="lock-container">
        <div class="shield-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>

        <div class="badge">Remote Kill-Switch Activated</div>

        <h1>সফটওয়্যার লাইসেন্স সাময়িকভাবে স্থগিত</h1>
        <p class="subtitle">
            ডেভেলপার লাইসেন্স সার্ভার থেকে এই অ্যাপ্লিকেশনটির লাইসেন্স সাময়িকভাবে স্থগিত বা নিষ্ক্রিয় করা হয়েছে।
        </p>

        <div class="details-box">
            <div class="detail-row">
                <span class="detail-label">Reason:</span>
                <span class="detail-val">{{ $reason ?? 'License Verification Failed or Suspended by Developer' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Status Code:</span>
                <span class="detail-val">403_LICENSE_REVOKED</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Server Host:</span>
                <span class="detail-val" style="color: #cbd5e1;">{{ $host ?? request()->getHost() }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Timestamp:</span>
                <span class="detail-val" style="color: #cbd5e1;">{{ now()->toDateTimeString() }}</span>
            </div>
        </div>

        <div class="notice-box">
            <strong>বিজ্ঞপ্তি:</strong><br>
            বকেয়া পরিশোধ, লাইসেন্স নবায়ন বা চুক্তিভিত্তিক শর্ত পূরণের জন্য অবিলম্বে সফটওয়্যার ডেভেলপার বা অথরাইজড এজেন্সির সাথে যোগাযোগ করুন। লাইসেন্স সার্ভার পুনরায় সক্রিয় না করা পর্যন্ত ওয়েবসাইটের কার্যকারিতা বন্ধ থাকবে।
        </div>

        <div class="contact-box">
            সফটওয়্যার ডেভেলপার যোগাযোগ: <strong>Ln Md Saiful Chowdhury</strong> &bull; মোবাইল: <strong>+880 1852-186180</strong>
        </div>

        <div class="footer-info">
            &copy; {{ date('Y') }} Proprietary & Protected Software License Management System.
        </div>
    </div>
</body>
</html>
