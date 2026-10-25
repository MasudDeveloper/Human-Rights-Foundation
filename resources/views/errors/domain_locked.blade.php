<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সফটওয়্যার লাইসেন্স সুরক্ষা | 403 Forbidden - Domain Locked</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&family=Outfit:wght@400;600;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            background: radial-gradient(circle at 50% 30%, #1e1b4b 0%, #09090b 80%);
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
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(239, 68, 68, 0.4);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            padding: 40px 36px;
            box-shadow: 0 25px 60px -15px rgba(239, 68, 68, 0.25), 0 0 40px rgba(0, 0, 0, 0.6);
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        .lock-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #ef4444, #f59e0b, #ef4444);
            animation: glow 3s linear infinite;
        }
        @keyframes glow {
            0% { filter: hue-rotate(0deg); }
            100% { filter: hue-rotate(360deg); }
        }
        .shield-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            background: rgba(239, 68, 68, 0.12);
            border: 2px solid rgba(239, 68, 68, 0.35);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
        }
        .shield-icon svg {
            width: 44px;
            height: 44px;
        }
        .badge {
            display: inline-block;
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 4px 14px;
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
            color: #94a3b8;
            margin-bottom: 24px;
            line-height: 1.6;
        }
        .details-box {
            background: rgba(2, 6, 23, 0.7);
            border: 1px dashed rgba(148, 163, 184, 0.25);
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
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            color: #94a3b8;
        }
        .detail-val {
            color: #f87171;
            font-weight: 600;
        }
        .legal-notice {
            font-size: 13px;
            color: #cbd5e1;
            line-height: 1.7;
            background: rgba(239, 68, 68, 0.06);
            border-left: 3px solid #ef4444;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            text-align: left;
            margin-bottom: 24px;
        }
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
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
            </svg>
        </div>

        <div class="badge">Security Protection Active</div>

        <h1>অননুমোদিত ডোমেন ও লাইসেন্স সুরক্ষা</h1>
        <p class="subtitle">
            এই ওয়েব অ্যাপ্লিকেশনটির সোর্স কোড ও ডাটাবেস শুধুমাত্র অনুমোদিত ডোমেনের জন্য সক্রিয় এবং সুরক্ষিত।
        </p>

        <div class="details-box">
            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-val">403 FORBIDDEN / LICENSE LOCKED</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Detected Host:</span>
                <span class="detail-val">{{ $currentHost }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Client IP:</span>
                <span class="detail-val" style="color: #cbd5e1;">{{ $requestIp }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Timestamp:</span>
                <span class="detail-val" style="color: #cbd5e1;">{{ $timestamp }}</span>
            </div>
        </div>

        <div class="legal-notice">
            <strong>আইনি সতর্কতা (Legal Notice):</strong><br>
            এই সফটওয়্যারটি আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের অফিসিয়াল কার্যক্রমের জন্য তৈরি করা হয়েছে। অননুমোদিতভাবে এই সোর্স কোড ডাউনলোড, অন্য ডোমেনে হোস্টিং বা পুনরায় ব্যবহার কপিরাইট ও ডিজিটাল নিরাপত্তা আইনের লঙ্ঘন।
        </div>

        <div class="footer-info">
            &copy; {{ date('Y') }} International Legal Aid & Human Rights Foundation. All rights reserved.
        </div>
    </div>
</body>
</html>
