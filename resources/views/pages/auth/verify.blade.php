@extends('layouts.app')

@section('title', 'Verify OTP - ShopZone')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl border border-gray-200 shadow-xl p-8 sm:p-10 space-y-8">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto text-2xl shadow-inner">
                <i class="fa-solid fa-lock"></i>
            </div>
            <h1 class="text-2xl font-black text-gray-900">Enter Verification Code</h1>
            <p class="text-xs text-gray-500">We've generated an OTP for: <span class="font-bold text-gray-800">{{ $email }}</span></p>
        </div>

        <!-- Highlighted Demo OTP Banner -->
        @if(session('demo_otp'))
            <div class="bg-emerald-50 border border-emerald-300 rounded-2xl p-4 text-center">
                <p class="text-xs font-bold text-emerald-800 uppercase tracking-wider mb-1">Your Demo Passcode:</p>
                <div class="text-3xl font-mono font-black text-emerald-600 tracking-widest cursor-pointer select-all" 
                     onclick="document.getElementById('otp').value='{{ session('demo_otp') }}'">
                    {{ session('demo_otp') }}
                </div>
                <p class="text-[11px] text-emerald-600 mt-1">(Click the numbers above to auto-fill)</p>
            </div>
        @endif

        <!-- Form: Step 2 Verify OTP -->
        <form action="{{ route('login.otp.verify') }}" method="POST" class="space-y-5">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="otp" class="block text-xs font-bold uppercase tracking-wider text-gray-700 mb-1.5 text-center">6-Digit Code</label>
                <input type="text" name="otp" id="otp" required maxlength="6" autofocus
                    value="{{ session('demo_otp') ?? old('otp') }}" 
                    placeholder="• • • • • •"
                    class="w-full text-center tracking-[0.5em] font-mono text-2xl font-bold bg-gray-50 border border-gray-300 rounded-xl py-3 text-gray-900 focus:bg-white focus:border-blue-500 focus:outline-none transition">
            </div>

            <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-emerald-500/30 transition flex items-center justify-center space-x-2">
                <span>Verify & Login</span>
                <i class="fa-solid fa-circle-check text-xs"></i>
            </button>
        </form>

        <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100">
            <a href="{{ route('login') }}" class="hover:text-blue-600 flex items-center space-x-1">
                <i class="fa-solid fa-arrow-left text-[10px]"></i>
                <span>Change Email</span>
            </a>
            
            <form action="{{ route('login.otp.send') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="text-blue-600 font-semibold hover:underline">
                    Resend Code
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
