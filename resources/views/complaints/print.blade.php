<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লিখিত অভিযোগ পত্র - #{{ $complaint->id }} - {{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</title>
    
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
            padding: 34px 42px;
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

        /* Header Hierarchy */
        .header {
            text-align: center;
            margin-bottom: 12px;
        }
        .header-logo {
            width: 82px;
            height: 82px;
            object-fit: contain;
            margin: 0 auto 6px auto;
            display: block;
        }
        .org-name-en {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 19px;
            font-weight: 800;
            color: #0a2540;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            line-height: 1.25;
        }
        .org-name-bn {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }
        .org-tagline {
            font-size: 11.5px;
            font-weight: 600;
            color: #475569;
            margin: 0 0 3px 0;
        }
        .org-address {
            font-size: 10.5px;
            color: #64748b;
            margin: 0;
            line-height: 1.4;
        }

        /* Official Double Line Divider */
        .header-divider {
            display: flex;
            flex-direction: column;
            gap: 2px;
            margin: 10px 0 14px 0;
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
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            box-shadow: 0 2px 4px rgba(10,37,64,0.18);
        }

        /* Metadata Bar */
        .meta-bar {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
            gap: 8px 14px;
            align-items: center;
            background: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 8px 16px;
            font-size: 11.5px;
            margin-bottom: 16px;
            color: #334155;
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
            margin: 14px 0 8px 0;
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
            margin-bottom: 12px;
            page-break-inside: avoid;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 7px 10px;
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
        .table-data-list th {
            background-color: #f1f5f9;
            color: #0a2540;
            font-weight: 700;
            text-align: left;
            font-size: 11.5px;
        }
        .table-data-list td {
            font-size: 11.5px;
        }

        /* Details text area */
        .details-cell {
            line-height: 1.6;
            min-height: 70px;
            white-space: pre-line;
            background-color: #ffffff;
        }

        /* Signatures Block */
        .signature-area {
            margin-top: 38px;
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
            width: 90px;
            height: 55px;
            margin: 0 auto 8px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #94a3b8;
            font-size: 10px;
            background: #fafafa;
        }

        /* Footer */
        .footer-note {
            border-top: 1px solid #cbd5e1;
            margin-top: 28px;
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

        /* Print Media Styles */
        @media print {
            @page {
                size: A4 portrait;
                margin: 12mm 15mm;
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
                <img src="{{ $siteLogo }}" class="header-logo" alt="Organization Seal">
                
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

                <!-- Official Legal Double Border -->
                <div class="header-divider">
                    <div class="thick"></div>
                    <div class="thin"></div>
                </div>

                <!-- Form Badge -->
                <div class="title-badge-wrap">
                    <span class="title-badge">লিখিত অভিযোগ পত্র / ফরম</span>
                </div>
            </div>

            <!-- Metadata Information Strip -->
            <div class="meta-bar">
                <span>
                    <strong>ট্র্যাকিং আইডি:</strong> 
                    <span style="font-family: monospace; font-size: 13px; font-weight: 800; color: #0a2540;">#{{ $complaint->id }}</span>
                </span>
                <span>
                    <strong>দাখিলের তারিখ:</strong> 
                    {{ $complaint->created_at ? $complaint->created_at->format('d/m/Y, h:i A') : $complaint->time }}
                </span>
                <span>
                    <strong>বর্তমান অবস্থা:</strong> 
                    @php
                        $statusClass = match($complaint->status) {
                            'approved' => 'status-approved',
                            'rejected' => 'status-rejected',
                            default => 'status-pending',
                        };
                    @endphp
                    <span class="badge-status {{ $statusClass }}">
                        {{ $complaint->status_badge['label'] }}
                    </span>
                </span>
            </div>

            <!-- 1. Complainant Personal Details -->
            <div class="section-header">
                <span><i class="fa-solid fa-user-shield"></i> ১. অভিযোগকারীর ব্যক্তিগত বিবরণ</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Complainant Details</span>
            </div>
            <table>
                <tr>
                    <th>অভিযোগকারীর নাম</th>
                    <td><strong>{{ $complaint->name }}</strong></td>
                    <th style="width: 15%;">বয়স</th>
                    <td>{{ $complaint->age }} বছর</td>
                </tr>
                <tr>
                    <th>পিতার নাম</th>
                    <td>{{ $complaint->father_name ?: '-' }}</td>
                    <th style="width: 15%;">মাতার নাম</th>
                    <td>{{ $complaint->mother_name ?: '-' }}</td>
                </tr>
                <tr>
                    <th>স্বামী/স্ত্রীর নাম</th>
                    <td>{{ $complaint->spouse_name ?: '-' }}</td>
                    <th style="width: 15%;">মোবাইল নম্বর</th>
                    <td><strong style="color: #0a2540;">{{ $complaint->phone_number }}</strong></td>
                </tr>
                <tr>
                    <th>ঠিকানা</th>
                    <td colspan="3">
                        গ্রাম/মহল্লা: {{ $complaint->village ?: '-' }}, 
                        ডাকঘর: {{ $complaint->post_office ?: '-' }}, 
                        থানা: {{ $complaint->thana ?: '-' }}, 
                        জেলা: {{ $complaint->district ?: '-' }}
                    </td>
                </tr>
            </table>

            <!-- 2. Complaint Nature & Narrative -->
            <div class="section-header">
                <span><i class="fa-solid fa-scale-balanced"></i> ২. অভিযোগের ধরণ ও ঘটনার বিস্তারিত বিবরণ</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Details of Complaint</span>
            </div>
            <table>
                <tr>
                    <th>অভিযোগের ধরণ / বিষয়</th>
                    <td colspan="3"><strong style="color: #b45309;">{{ $complaint->complaint_type }}</strong></td>
                </tr>
                <tr>
                    <th>ঘটনার পূর্ণ বিবরণ</th>
                    <td colspan="3" class="details-cell">
                        {{ $complaint->details ?: 'কোনো বিস্তারিত বিবরণ প্রদান করা হয়নি।' }}
                    </td>
                </tr>
            </table>

            <!-- 3. Accused List -->
            <div class="section-header">
                <span><i class="fa-solid fa-users"></i> ৩. অভিযুক্ত ব্যক্তি / আসামির তালিকা</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">List of Accused</span>
            </div>
            @if($complaint->accuseds && $complaint->accuseds->count() > 0)
                <table class="table-data-list">
                    <thead>
                        <tr>
                            <th style="width: 6%; text-align: center;">নং</th>
                            <th style="width: 28%;">আসামির নাম</th>
                            <th style="width: 14%;">বয়স</th>
                            <th style="width: 24%;">পিতার নাম</th>
                            <th style="width: 28%;">ঠিকানা ও যোগাযোগ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaint->accuseds as $idx => $acc)
                            <tr>
                                <td style="text-align: center; font-weight: 600;">{{ $idx + 1 }}</td>
                                <td><strong>{{ $acc->name }}</strong></td>
                                <td>{{ $acc->age ? $acc->age . ' বছর' : '-' }}</td>
                                <td>{{ $acc->father_name ?: '-' }}</td>
                                <td>
                                    {{ $acc->address }}
                                    @if($acc->phone)
                                        <br><span style="font-size: 10.5px; color: #475569;"><i class="fa-solid fa-phone"></i> {{ $acc->phone }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table>
                    <tr>
                        <td style="color: #64748b; font-style: italic; padding: 10px;">নির্দিষ্ট কোনো অভিযুক্ত ব্যক্তি বা আসামির নাম উল্লেখ করা হয়নি।</td>
                    </tr>
                </table>
            @endif

            <!-- 4. Witnesses List -->
            <div class="section-header">
                <span><i class="fa-solid fa-eye"></i> ৪. সাক্ষীদের তালিকা</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">List of Witnesses</span>
            </div>
            @if($complaint->witnesses && $complaint->witnesses->count() > 0)
                <table class="table-data-list">
                    <thead>
                        <tr>
                            <th style="width: 6%; text-align: center;">নং</th>
                            <th style="width: 32%;">সাক্ষীর নাম</th>
                            <th style="width: 28%;">পিতার নাম</th>
                            <th style="width: 34%;">ঠিকানা ও মোবাইল</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaint->witnesses as $idx => $w)
                            <tr>
                                <td style="text-align: center; font-weight: 600;">{{ $idx + 1 }}</td>
                                <td><strong>{{ $w->name }}</strong></td>
                                <td>{{ $w->father_name ?: '-' }}</td>
                                <td>
                                    {{ $w->address }}
                                    @if($w->phone_number)
                                        <span style="color: #475569;"> (মোবাইল: {{ $w->phone_number }})</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <table>
                    <tr>
                        <td style="color: #64748b; font-style: italic; padding: 10px;">কোনো সাক্ষীর নাম উল্লেখ করা হয়নি।</td>
                    </tr>
                </table>
            @endif

            <!-- 5. Processing Fee & Payment Details -->
            <div class="section-header">
                <span><i class="fa-solid fa-receipt"></i> ৫. আবেদন ফি ও পেমেন্ট বিবরণী</span>
                <span style="font-size: 10px; font-weight: normal; opacity: 0.85;">Payment Information</span>
            </div>
            <table>
                <tr>
                    <th>পেমেন্ট মেথড</th>
                    <td><strong>{{ $complaint->payment_gateway ?: 'অনলাইন' }}</strong></td>
                    <th>প্রেরক মোবাইল নম্বর</th>
                    <td><strong>{{ $complaint->payment_number ?: '-' }}</strong></td>
                </tr>
                <tr>
                    <th>ট্রানজেকশন আইডি (TrxID)</th>
                    <td><strong style="font-family: monospace; font-size: 13px; color: #059669;">{{ $complaint->transaction_id ?: '-' }}</strong></td>
                    <th>পরিশোধিত ফি</th>
                    <td><strong style="color: #0a2540;">৳{{ $complaint->payment_amount ?: '২৫০' }} টাকা</strong> (ফি সম্পন্ন)</td>
                </tr>
            </table>

            <!-- Signatures Section -->
            <div class="signature-area">
                <div class="signature-box">
                    <div style="height: 50px; display: flex; align-items: flex-end; justify-content: center;">
                        <span style="font-family: 'Hind Siliguri', cursive; font-size: 15px; color: #0a2540;">{{ $complaint->signature ?: $complaint->name }}</span>
                    </div>
                    <div class="signature-line"></div>
                    <p class="signer-name">{{ $complaint->name }}</p>
                    <p class="signer-title">অভিযোগকারীর স্বাক্ষর ও তারিখ</p>
                </div>

                <div class="signature-box">
                    <div class="seal-box">
                        <span>সিল মোহর</span>
                    </div>
                    <div class="signature-line"></div>
                    <p class="signer-name">আইনি তদন্ত সেল</p>
                    <p class="signer-title">তদন্ত কর্মকর্তার সিল ও স্বাক্ষর</p>
                </div>

                <div class="signature-box">
                    <div style="height: 50px; display: flex; align-items: flex-end; justify-content: center;">
                        @if(!empty($authorizedSignatureUrl))
                            <img src="{{ $authorizedSignatureUrl }}" alt="Signature" style="max-height: 48px; max-width: 140px; object-fit: contain;">
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
                    এই লিখিত অভিযোগপত্রটি <strong>{{ $siteSettings['org_name_bn'] ?? 'আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন' }}</strong>-এর কেন্দ্রীয় সার্ভারে সংরক্ষিত এবং আইনি পর্যালোচনার জন্য গৃহীত।
                </p>
                <p style="margin: 0;">
                    প্রধান কার্যালয়: {{ $siteSettings['site_address'] ?? 'Head Office-37/2, Fayenez Bhabon, lift-08purana Paltan,culbut Road,dhaka' }} | হেল্পলাইন: {{ $siteSettings['site_phone'] ?? '01758343597' }} | ইমেইল: {{ $siteSettings['site_email'] ?? 'ilhrfbd@gmail.com' }}
                </p>
            </div>

        </div>
    </div>

</body>
</html>
