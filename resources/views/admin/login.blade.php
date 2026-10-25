<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন লগইন - আন্তর্জাতিক মানবাধিকার আইন সহায়তাকারী ফাউন্ডেশন</title>
    <link rel="icon" type="image/png" href="{{ asset('images/org_logo_new.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

    <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 border border-slate-800">
        <div class="text-center mb-6">
            <img src="{{ asset('images/org_logo_new.png') }}" alt="Logo" class="w-16 h-16 mx-auto mb-2 bg-white p-1 rounded-full shadow border">
            <h1 class="text-xl font-bold text-slate-900">অ্যাডমিন প্যানেল</h1>
            <p class="text-xs text-slate-500 mt-1">প্রশাসনিক কার্যক্রমে প্রবেশ করতে লগইন করুন</p>
        </div>

        @if($errors->any())
            <div class="p-3 mb-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">ইউজারনেম</label>
                <div class="relative">
                    <i class="fa-solid fa-user-tie absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="text" name="username" value="{{ old('username') }}" required placeholder="username"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-slate-900">
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">পাসওয়ার্ড</label>
                <div class="relative">
                    <i class="fa-solid fa-lock absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                    <input type="password" name="password" required placeholder="password"
                        class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-slate-300 text-xs sm:text-sm focus:ring-2 focus:ring-slate-900">
                </div>
            </div>

            <button type="submit" class="w-full py-3 rounded-xl bg-slate-900 hover:bg-slate-800 text-amber-400 font-bold text-xs sm:text-sm shadow-md transition flex items-center justify-center space-x-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>প্রবেশ করুন</span>
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 text-center">
            <a href="{{ route('home') }}" class="text-xs text-slate-500 hover:text-slate-900 font-medium">
                <i class="fa-solid fa-arrow-left mr-1"></i>মূল ওয়েবসাইটে ফিরে যান
            </a>
        </div>
    </div>

</body>
</html>
