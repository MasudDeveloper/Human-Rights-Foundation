<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডিজিটাল আইডি কার্ড - {{ $member->english_name ?: $member->bangla_name }} ({{ $member->member_id_card_number }})</title>
    
    <link rel="icon" type="image/png" href="{{ $siteFavicon }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800;900&family=Hind+Siliguri:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Hind Siliguri', sans-serif;
            background: linear-gradient(135deg, #09131f 0%, #0d2238 50%, #081626 100%);
        }

        /* Standard CR80 PVC ID Card Dimensions (Ratio 442 : 695) */
        .id-card {
            width: 340px;
            height: 535px;
            border-radius: 18px;
            position: relative;
            background-color: #ffffff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.65), 0 0 0 1px rgba(255, 255, 255, 0.15);
            overflow: hidden;
            flex-shrink: 0;
            user-select: none;
        }

        .card-front {
            background-image: url("{{ asset('images/id_card_front_bg.png') }}");
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        .card-back {
            background-image: url("{{ asset('images/id_card_back_bg.png') }}");
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Circular Photo Container centered at X=50%, Top=91px, Diameter=211px */
        .front-photo-frame {
            position: absolute;
            top: 91px;
            left: 50%;
            transform: translateX(-50%);
            width: 211px;
            height: 211px;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.18);
            overflow: hidden;
            background: #e2e8f0;
            z-index: 10;
        }

        /* Print Settings */
        @media print {
            body {
                background: #ffffff !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print {
                display: none !important;
            }
            .print-container {
                display: flex !important;
                flex-direction: row !important;
                gap: 20px !important;
                justify-content: center !important;
                align-items: center !important;
                padding-top: 15px !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            .id-card {
                box-shadow: none !important;
                border: 0.5px solid #cbd5e1 !important;
                page-break-inside: avoid !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 py-8 px-4 flex flex-col items-center justify-center">

    <!-- Top Action Bar (Screen Only) -->
    <div class="no-print w-full max-w-4xl mb-6 flex flex-wrap justify-between items-center gap-3 bg-slate-900/90 backdrop-blur-md p-4 rounded-2xl border border-slate-700/70 text-white shadow-2xl">
        <div class="flex items-center space-x-3">
            <a href="{{ route('members.directory') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold transition flex items-center space-x-1.5 border border-slate-700">
                <i class="fa-solid fa-arrow-left"></i>
                <span>সদস্য তালিকা</span>
            </a>
            <span class="text-xs text-slate-500">|</span>
            <div class="flex items-center space-x-1.5">
                <i class="fa-solid fa-id-badge text-sky-400 text-xs"></i>
                <span class="text-xs font-mono font-bold text-sky-300">ID: {{ $member->member_id_card_number }}</span>
            </div>
            <span class="text-xs font-bold text-slate-300 truncate max-w-[200px]">({{ $member->english_name ?: $member->bangla_name }})</span>
        </div>

        <div class="flex items-center space-x-2">
            @if(session('admin_logged_in') && session('admin_role') === 'super_admin')
                <a href="{{ route('admin.settings') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-amber-300 font-bold text-xs transition flex items-center space-x-1 border border-slate-700">
                    <i class="fa-solid fa-sliders"></i>
                    <span>সেটিংস</span>
                </a>
            @endif
            <a href="{{ route('member.verify', ['search' => $member->member_id_card_number]) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white font-bold text-xs transition flex items-center space-x-1.5 shadow">
                <i class="fa-solid fa-circle-check"></i>
                <span>অনলাইন ভেরিফাই</span>
            </a>
            <button onclick="window.print()" class="px-4 py-1.5 rounded-xl bg-gradient-to-r from-sky-400 to-blue-600 hover:from-sky-300 hover:to-blue-500 text-white font-black text-xs shadow-lg transition flex items-center space-x-1.5">
                <i class="fa-solid fa-print"></i>
                <span>প্রিন্ট / PDF ডাউনলোড</span>
            </button>
        </div>
    </div>

    <!-- ID Cards Container (Front & Back Side-by-Side) -->
    <div class="print-container flex flex-col md:flex-row gap-8 items-center justify-center">
        
        <!-- ================= CARD FRONT ================= -->
        <div class="id-card card-front">
            
            <!-- Circular Profile Photo -->
            <div class="front-photo-frame">
                @if($member->effective_photo)
                    <img src="{{ $member->effective_photo }}" alt="{{ $member->bangla_name }}" class="w-full h-full object-cover">
                @else
                    <!-- Professional Avatar Placeholder -->
                    <div class="w-full h-full bg-gradient-to-b from-slate-100 to-slate-200 flex flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-user-tie text-7xl text-slate-400 mb-1"></i>
                        <span class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">MEMBER</span>
                    </div>
                @endif
            </div>

            <!-- Member Name & Designation -->
            <div class="absolute top-[312px] left-0 w-full px-4 text-center z-10">
                <h2 class="font-extrabold text-[15px] leading-tight text-black tracking-wide uppercase truncate">
                    {{ strtoupper($member->english_name ?: $member->bangla_name) }}
                </h2>
                <p class="font-medium text-[13px] text-gray-900 leading-tight mt-1">
                    {{ $member->post_name ?: 'Chairman' }}
                </p>
            </div>

            <!-- Key-Value Information Table -->
            <div class="absolute top-[360px] left-0 w-full flex justify-center z-10">
                <table class="text-[11.5px] font-bold text-black border-collapse select-text">
                    <tbody>
                        <tr>
                            <td class="pr-2 py-[2.5px] text-left">ID NO</td>
                            <td class="px-1 py-[2.5px] text-center">:</td>
                            <td class="pl-2 py-[2.5px] font-mono tracking-wider text-left">{{ $member->member_id_card_number }}</td>
                        </tr>
                        <tr>
                            <td class="pr-2 py-[2.5px] text-left">Blood</td>
                            <td class="px-1 py-[2.5px] text-center">:</td>
                            <td class="pl-2 py-[2.5px] text-left">{{ $member->blood_group ?: 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="pr-2 py-[2.5px] text-left">Phone</td>
                            <td class="px-1 py-[2.5px] text-center">:</td>
                            <td class="pl-2 py-[2.5px] font-mono text-left">{{ $member->phone_number }}</td>
                        </tr>
                        <tr>
                            <td class="pr-2 py-[2.5px] text-left">NID</td>
                            <td class="px-1 py-[2.5px] text-center">:</td>
                            <td class="pl-2 py-[2.5px] font-mono text-left">{{ $member->nid ?: 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>


        <!-- ================= CARD BACK ================= -->
        <div class="id-card card-back">

            <!-- QR Code for Instant Smartphone Online Verification -->
            <div class="absolute top-[142px] left-1/2 -translate-x-1/2 w-[104px] h-[104px] flex items-center justify-center bg-white z-10">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ urlencode(route('member.verify', ['search' => $member->member_id_card_number])) }}" 
                     alt="Online Verification QR" 
                     class="w-[104px] h-[104px] object-contain">
            </div>

            <!-- Contact & Head Office Details -->
            <div class="absolute top-[266px] left-0 w-full px-8 text-[10.5px] text-black leading-[1.38] font-medium z-10 select-text">
                <p><span class="font-bold">Mobile:</span> {{ $settings['site_phone'] ?? '01758343597' }}</p>
                <p><span class="font-bold">E-mail:</span> {{ $settings['site_email'] ?? 'manushmanusherjonna@gmail.com' }}</p>
                <p class="text-[9.5px] text-blue-900 break-all leading-tight">{{ $settings['site_website'] ?? 'https://internationallegalaidhumanrightsfoundration.org' }}</p>
                
                <div class="pt-2 text-[10px] leading-[1.35]">
                    <p>Head Office-{{ $settings['id_card_office_address'] ?? '37/2, Fayenez Bhabon' }}</p>
                    <p>{{ $settings['id_card_office_address_2'] ?? 'lift-08purana Paltan,culbut Road,dhaka' }}</p>
                </div>
            </div>

            <!-- Authorized Signature (if uploaded by Admin) -->
            @if(!empty($authorizedSignatureUrl))
                <div class="absolute right-7 bottom-[92px] w-24 h-10 flex items-end justify-center bg-white z-10 pointer-events-none">
                    <img src="{{ $authorizedSignatureUrl }}" alt="Signature" class="max-h-9 max-w-full object-contain">
                </div>
            @endif

        </div>

    </div>

    <!-- Print instructions helper for users -->
    <div class="no-print mt-6 text-center text-xs text-slate-400">
        <p><i class="fa-solid fa-circle-info mr-1 text-sky-400"></i> কার্ডটি প্রিন্ট করার জন্য প্রিন্ট ডায়ালগে <span class="text-sky-300 font-semibold">"Background graphics"</span> অপশনটি চেক মার্ক করুন।</p>
    </div>

</body>
</html>
