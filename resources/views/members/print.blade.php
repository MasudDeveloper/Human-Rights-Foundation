<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সদস্য আবেদন ফরম - #{{ $member->id }} - {{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</title>
    
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body {
            font-family: 'Hind Siliguri', 'Kalpurush', sans-serif;
            background-color: #f1f5f9;
            margin: 0;
            padding: 24px;
            color: #0f172a;
            -webkit-font-smoothing: antialiased;
        }
        .print-container {
            background: #ffffff;
            max-width: 860px;
            margin: 0 auto;
            padding: 32px 40px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            position: relative;
        }

        /* Watermark Background */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 380px;
            opacity: 0.04;
            pointer-events: none;
            z-index: 0;
        }

        .content-layer {
            position: relative;
            z-index: 1;
        }

        /* Header Layout: 3 Columns (Logo - Text - Photo) */
        .header {
            margin-bottom: 12px;
        }
        .header-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .header-logo-col {
            flex-shrink: 0;
            width: 85px;
            text-align: center;
        }
        .header-logo {
            width: 78px;
            height: 78px;
            object-fit: contain;
            display: block;
            margin: 0 auto;
        }
        .header-text-col {
            flex-grow: 1;
            text-align: center;
        }
        .header-photo-col {
            flex-shrink: 0;
            width: 95px;
            display: flex;
            justify-content: flex-end;
        }
        .photo-box-wrap {
            width: 95px;
            height: 115px;
            border: 1.5px solid #0a2540;
            border-radius: 6px;
            overflow: hidden;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 2px;
        }
        .photo-box-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }
        .photo-box-wrap .placeholder-text {
            font-size: 9.5px;
            color: #64748b;
            font-weight: 600;
            line-height: 1.3;
        }

        /* Header Typography */
        .org-name-en {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 17.5px;
            font-weight: 800;
            color: #0a2540;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            line-height: 1.25;
        }
        .org-name-bn {
            font-size: 15.5px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 3px 0;
            line-height: 1.3;
        }
        .org-tagline {
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            margin: 0 0 2px 0;
        }
        .org-address {
            font-size: 10px;
            color: #64748b;
            margin: 0;
            line-height: 1.4;
        }

        /* Official Double Line Divider */
        .header-divider {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin: 10px 0 12px 0;
        }
        .header-divider .thick {
            height: 2.5px;
            background: #0a2540;
            width: 100%;
        }
        .header-divider .thin {
            height: 1px;
            background: #0a2540;
            width: 100%;
        }

        /* Form Title Badge */
        .title-badge-wrap {
            text-align: center;
            margin-bottom: 14px;
        }
        .title-badge {
            background: #0a2540;
            color: #ffffff;
            display: inline-block;
            padding: 5px 28px;
            border-radius: 6px;
            font-size: 13.5px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(10,37,64,0.18);
        }

        /* Metadata Bar */
        .meta-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 8px 14px;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 11.5px;
            margin-bottom: 14px;
            color: #334155;
            align-items: center;
        }
        .meta-bar strong {
            color: #0f172a;
        }
        .badge-status {
            padding: 2px 10px;
            border-radius: 9999px;
            font-weight: 700;
            font-size: 11px;
            display: inline-block;
            border: 1px solid transparent;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            border-color: #fde68a;
        }
        .status-approved {
            background-color: #d1fae5;
            color: #065f46;
            border-color: #a7f3d0;
        }
        .status-rejected {
            background-color: #ffe4e6;
            color: #9f1239;
            border-color: #fecdd3;
        }

        /* Section Header */
        .section-header {
            background: #0a2540;
            color: #ffffff;
            font-weight: 700;
            font-size: 12px;
            padding: 6px 12px;
            border-radius: 4px;
            margin: 12px 0 6px 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            letter-spacing: 0.3px;
        }
        .section-header i {
            margin-right: 6px;
            color: #fbbf24;
            font-size: 11px;
        }

        /* Clean Institutional Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 10px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 10px;
            vertical-align: middle;
            line-height: 1.45;
        }
        th {
            background-color: #f8fafc;
            text-align: left;
            width: 22%;
            color: #334155;
            font-weight: 600;
        }
        td {
            color: #0f172a;
            background-color: #ffffff;
        }

        /* Signatures Block */
        .signature-area {
            margin-top: 32px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 11.5px;
            page-break-inside: avoid;
        }
        .signature-box {
            text-align: center;
            width: 210px;
        }
        .signature-line {
            border-top: 1.5px dashed #0a2540;
            margin-bottom: 5px;
            padding-top: 5px;
        }
        .signature-box .signer-name {
            font-weight: 700;
            color: #0a2540;
            margin: 0;
            font-size: 12px;
        }
        .signature-box .signer-title {
            color: #64748b;
            margin: 2px 0 0 0;
            font-size: 11px;
        }
        .seal-box {
            border: 1.5px dashed #cbd5e1;
            border-radius: 8px;
            width: 85px;
            height: 50px;
            margin: 0 auto 6px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 10px;
            background: #fafafa;
        }

        /* Declaration Box */
        .declaration-box {
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 3px solid #0a2540;
            border-radius: 4px;
            padding: 7px 12px;
            font-size: 11px;
            color: #475569;
            line-height: 1.5;
            margin-top: 10px;
        }

        /* Footer */
        .footer-note {
            border-top: 1px solid #cbd5e1;
            margin-top: 24px;
            padding-top: 8px;
            text-align: center;
            font-size: 10px;
            color: #64748b;
            line-height: 1.5;
            page-break-inside: avoid;
        }

        /* Action Buttons (Screen Only) */
        .btn-action-bar {
            position: fixed;
            top: 20px;
            right: 24px;
            display: flex;
            gap: 10px;
            z-index: 9999;
        }
        .btn-print {
            background: linear-gradient(135deg, #059669, #047857);
            color: #ffffff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.35);
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-print:hover {
            background: linear-gradient(135deg, #047857, #065f46);
            box-shadow: 0 6px 16px rgba(5, 150, 105, 0.45);
            transform: translateY(-1px);
        }
        .btn-back {
            background: #1e293b;
            color: #ffffff;
            padding: 10px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        .btn-back:hover {
            background: #0f172a;
        }

        /* Responsive adjustments for mobile/narrow viewports */
        @media (max-width: 640px) {
            .header-top {
                flex-direction: column;
                text-align: center;
            }
            .header-photo-col {
                order: 3;
                width: 100%;
                justify-content: center;
                margin-top: 8px;
            }
            .header-logo-col {
                order: 1;
                margin-bottom: 4px;
            }
            .header-text-col {
                order: 2;
            }
        }

        /* Print Media Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm 14mm;
            }
            body {
                background: #ffffff !important;
                padding: 0 !important;
                color: #000000;
            }
            .print-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                max-width: 100% !important;
            }
            .btn-action-bar {
                display: none !important;
            }
            table, tr, td, th {
                page-break-inside: avoid;
            }
            .section-header {
                background: #0a2540 !important;
                color: #ffffff !important;
            }
            .title-badge {
                background: #0a2540 !important;
                color: #ffffff !important;
            }
        }
    </style>
</head>
<body>

    <!-- Screen Action Bar -->
    <div class="btn-action-bar">
        <a href="javascript:window.history.back()" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> পূর্ববর্তী পেজ
        </a>
        <button onclick="window.print()" class="btn-print">
            <i class="fa-solid fa-print"></i> প্রিন্ট / PDF সংরক্ষণ করুন
        </button>
    </div>

    <div class="print-container">
        
        <!-- Watermark Seal -->
        <img src="{{ $siteLogo }}" class="watermark" alt="Watermark">

        <div class="content-layer">

            <!-- Official Header -->
            <div class="header">
                <div class="header-top">
                    <!-- Left: Logo -->
                    <div class="header-logo-col">
                        <img src="{{ $siteLogo }}" class="header-logo" alt="Organization Seal">
                    </div>

                    <!-- Center: Organization Details -->
                    <div class="header-text-col">
                        <!-- 1. English Name First (Large & Uppercase) -->
                        <h1 class="org-name-en">
                            {{ strtoupper($siteSettings['org_name_en'] ?? 'INTERNATIONAL LEGAL AID & HUMAN RIGHTS FOUNDATION') }}
                        </h1>
                        
                        <!-- 2. Bengali Name Second (Medium Size) -->
                        <h2 class="org-name-bn">
                            {{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}
                        </h2>

                        <!-- 3. Slogan & Affiliation -->
                        <p class="org-tagline">
                            {{ $siteSettings['site_slogan'] ?? 'ন্যায় বিচার প্রতিষ্ঠায় আপোষহীন' }} • গণপ্রজাতন্ত্রী বাংলাদেশ সরকার অনুমোদিত
                        </p>

                        <!-- 4. Address & Contact -->
                        <p class="org-address">
                            প্রধান কার্যালয়: {{ $siteSettings['site_address'] ?? 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka, বাংলাদেশ।' }} | হটলাইন: {{ $siteSettings['site_phone'] ?? '01758343597' }}
                        </p>
                    </div>

                    <!-- Right: Photo Box -->
                    <div class="header-photo-col">
                        <div class="photo-box-wrap">
                            @if($member->effective_photo)
                                <img src="{{ $member->effective_photo }}" alt="{{ $member->bangla_name }}">
                            @else
                                <i class="fa-solid fa-user text-slate-300 text-3xl mb-1"></i>
                                <span class="placeholder-text">পাসপোর্ট সাইজ ছবি</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Official Legal Double Border -->
                <div class="header-divider">
                    <div class="thick"></div>
                    <div class="thin"></div>
                </div>

                <!-- Form Badge -->
                <div class="title-badge-wrap">
                    <span class="title-badge">সদস্য পদের আবেদন ও নিবন্ধন ফরম</span>
                </div>
            </div>

            <!-- Metadata Information Strip -->
            <div class="meta-bar">
                <span>
                    <strong>আবেদন আইডি:</strong> 
                    <span style="font-family: monospace; font-size: 12.5px; font-weight: 800; color: #0a2540;">#{{ $member->id }}</span>
                </span>
                <span>
                    <strong>আবেদনের তারিখ:</strong> 
                    {{ $member->created_at ? $member->created_at->format('d/m/Y') : $member->time }}
                </span>
                <span>
                    <strong>আবেদনকৃত পদবী:</strong> 
                    <strong style="color: #b45309;">{{ $member->post_name }}</strong>
                </span>
                <span>
                    <strong>স্ট্যাটাস:</strong> 
                    @php
                        $statusClass = match($member->status) {
                            'approved' => 'status-approved',
                            'rejected' => 'status-rejected',
                            default => 'status-pending',
                        };
                    @endphp
                    <span class="badge-status {{ $statusClass }}">
                        {{ $member->status_badge['label'] }}
                    </span>
                </span>
            </div>

            <!-- 1. Personal Details -->
            <div class="section-header">
                <span><i class="fa-solid fa-id-card"></i> ১. ব্যক্তিগত তথ্য ও পরিচয়</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Personal Information</span>
            </div>
            <table>
                <tr>
                    <th>নাম (বাংলা)</th>
                    <td><strong>{{ $member->bangla_name }}</strong></td>
                    <th>নাম (ইংরেজি)</th>
                    <td style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; text-transform: uppercase;">
                        {{ $member->english_name }}
                    </td>
                </tr>
                <tr>
                    <th>পিতার নাম</th>
                    <td>{{ $member->father_name ?: '-' }}</td>
                    <th>মাতার নাম</th>
                    <td>{{ $member->mother_name ?: '-' }}</td>
                </tr>
                <tr>
                    <th>জন্ম তারিখ</th>
                    <td>{{ $member->date_of_birth ?: '-' }}</td>
                    <th>জাতীয় পরিচয়পত্র (NID)</th>
                    <td><strong style="font-family: monospace; font-size: 12.5px; color: #0a2540;">{{ $member->nid ?: '-' }}</strong></td>
                </tr>
                <tr>
                    <th>শিক্ষাগত যোগ্যতা</th>
                    <td>{{ $member->education ?: '-' }}</td>
                    <th>পেশা / কর্মসংস্থান</th>
                    <td>{{ $member->current_job ?: '-' }}</td>
                </tr>
                <tr>
                    <th>রক্তের গ্রুপ</th>
                    <td><strong style="color: #dc2626;">{{ $member->blood_group ?: 'অজানা' }}</strong></td>
                    <th>ধর্ম ও বৈবাহিক অবস্থা</th>
                    <td>{{ $member->religion ?: '-' }} / {{ $member->marital_status ?: '-' }}</td>
                </tr>
                @if($member->spouse_name)
                <tr>
                    <th>স্বামী / স্ত্রীর নাম</th>
                    <td>{{ $member->spouse_name }}</td>
                    <th>স্বামী / স্ত্রীর মোবাইল</th>
                    <td>{{ $member->spouse_number ?: '-' }}</td>
                </tr>
                @endif
                @if($member->member_id_card_number)
                <tr>
                    <th>অফিসিয়াল মেম্বার আইডি</th>
                    <td colspan="3"><strong style="font-family: monospace; font-size: 12.5px; color: #059669;">{{ $member->member_id_card_number }}</strong> (অনুমোদিত সদস্য)</td>
                </tr>
                @endif
            </table>

            <!-- 2. Addresses -->
            <div class="section-header">
                <span><i class="fa-solid fa-map-location-dot"></i> ২. ঠিকানা ও যোগাযোগের বিবরণ</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Address & Contact</span>
            </div>
            <table>
                <tr>
                    <th>স্থায়ী ঠিকানা</th>
                    <td colspan="3">
                        গ্রাম/মহল্লা: {{ $member->village ?: '-' }}, 
                        ডাকঘর: {{ $member->post_office ?: '-' }}, 
                        থানা: {{ $member->thana ?: '-' }}, 
                        জেলা: {{ $member->district ?: '-' }}
                    </td>
                </tr>
                <tr>
                    <th>বর্তমান ঠিকানা</th>
                    <td colspan="3">
                        গ্রাম/মহল্লা: {{ $member->village2 ?: '-' }}, 
                        ডাকঘর: {{ $member->post_office2 ?: '-' }}, 
                        থানা: {{ $member->thana2 ?: '-' }}, 
                        জেলা: {{ $member->district2 ?: '-' }}
                    </td>
                </tr>
                <tr>
                    <th>মোবাইল নম্বর</th>
                    <td><strong style="color: #0a2540;">{{ $member->phone_number }}</strong></td>
                    <th>ই-মেইল এড্রেস</th>
                    <td>{{ $member->email ?: '-' }}</td>
                </tr>
                @if($member->reference_name)
                <tr>
                    <th>রেফারেন্স / সুপারিশকারী</th>
                    <td>{{ $member->reference_name }}</td>
                    <th>রেফারেন্স পদবী</th>
                    <td>{{ $member->reference_post ?: '-' }}</td>
                </tr>
                @endif
            </table>

            <!-- 3. Payment Details -->
            <div class="section-header">
                <span><i class="fa-solid fa-receipt"></i> ৩. সদস্য নিবন্ধন ফি ও পেমেন্ট বিবরণী</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Registration Fee & Payment</span>
            </div>
            <table>
                <tr>
                    <th>পেমেন্ট মেথড</th>
                    <td><strong>{{ $member->payment_gateway ?: 'অনলাইন' }}</strong></td>
                    <th>প্রেরক মোবাইল নম্বর</th>
                    <td><strong>{{ $member->payment_number ?: '-' }}</strong></td>
                </tr>
                <tr>
                    <th>ট্রানজেকশন আইডি (TrxID)</th>
                    <td><strong style="font-family: monospace; font-size: 12.5px; color: #059669;">{{ $member->transaction_id ?: '-' }}</strong></td>
                    <th>পরিশোধিত ফি</th>
                    <td><strong style="color: #0a2540;">৳{{ $member->payment_amount ?: '২৫০' }} টাকা</strong> (ফি সম্পন্ন)</td>
                </tr>
            </table>

            <!-- Declaration -->
            <div class="declaration-box">
                <strong>ঘোষণাপত্র:</strong> আমি এই মর্মে শপথ করছি যে, উপরে বর্ণিত সকল তথ্য সম্পূর্ণ সত্য ও নির্ভুল। আমি আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশনের গঠনতন্ত্র, নিয়মাবলী ও আদর্শ মেনে চলার অঙ্গীকার করছি।
            </div>

            <!-- Signatures Section -->
            <div class="signature-area">
                <div class="signature-box">
                    <div style="height: 45px; display: flex; align-items: flex-end; justify-content: center;">
                        <span style="font-family: 'Hind Siliguri', cursive; font-size: 15px; color: #0a2540;">{{ $member->signature ?: $member->bangla_name }}</span>
                    </div>
                    <div class="signature-line"></div>
                    <p class="signer-name">{{ $member->bangla_name }}</p>
                    <p class="signer-title">আবেদনকারীর স্বাক্ষর ও তারিখ</p>
                </div>

                <div class="signature-box">
                    <div class="seal-box">
                        <span>সিল মোহর</span>
                    </div>
                    <div class="signature-line"></div>
                    <p class="signer-name">সমন্বয় শাখা</p>
                    <p class="signer-title">সুপারিশকারীর স্বাক্ষর ও পদবী</p>
                </div>

                <div class="signature-box">
                    <div style="height: 45px; display: flex; align-items: flex-end; justify-content: center;">
                        @if(!empty($authorizedSignatureUrl))
                            <img src="{{ $authorizedSignatureUrl }}" alt="Signature" style="max-height: 45px; max-width: 135px; object-fit: contain;">
                        @endif
                    </div>
                    <div class="signature-line"></div>
                    <p class="signer-name">{{ $siteSettings['authorized_signature_name'] ?? 'মহাসচিব / কেন্দ্রীয় নির্বাহী' }}</p>
                    <p class="signer-title">অনুমোদনকারী স্বাক্ষর ও অফিশিয়াল সিল</p>
                </div>
            </div>

            <!-- Official Footer Note -->
            <div class="footer-note">
                <p style="margin: 0 0 2px 0;">
                    এই সদস্য আবেদনটি <strong>{{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</strong>-এর কেন্দ্রীয় তথ্যভাণ্ডারে নথিভুক্ত।
                </p>
                <p style="margin: 0;">
                    প্রধান কার্যালয়: {{ $siteSettings['site_address'] ?? 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka' }} | হেল্পলাইন: {{ $siteSettings['site_phone'] ?? '01758343597' }} | ইমেইল: {{ $siteSettings['site_email'] ?? 'ilhrfbd@gmail.com' }}
                </p>
            </div>

        </div>
    </div>

</body>
</html>
