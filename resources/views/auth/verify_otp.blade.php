<x-auth.layout title="Verify OTP">

<div class="card-body login-card-body">

    <p class="login-box-msg">Enter OTP sent to your email</p>
    
    <form method="POST" action="{{ route('verify.otp') }}">
        @csrf

        {{-- Hidden email --}}
        <input type="hidden" name="email" value="{{ old('email', session('email')) }}">

        {{-- OTP Input --}}
        <div class="input-group mb-3">
            <input type="text" name="otp" class="form-control"
                   placeholder="Enter 6-digit OTP"
                   required maxlength="6">      
        </div>

        <button type="submit" class="btn btn-success btn-block">
            Verify OTP
        </button>
    </form>

    <!-- {{-- Stay Logged In --}} <div class="form-check mb-3"> <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember"> <label class="form-check-label" for="remember"> Stay logged in for 7 days </label> </div> -->

    {{-- Resend --}}
    <div class="text-center mt-3">
<div class="text-center mt-3">

<form method="POST" action="{{ route('resend.otp') }}" id="resendForm">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">

    <button id="resendBtn" class="btn btn-link" disabled>
        Resend OTP (<span id="countdown">60</span>s)
    </button>
</form>

</div>

<script>
    let seconds = 60;
    const countdown = document.getElementById('countdown');
    const btn = document.getElementById('resendBtn');

    const interval = setInterval(() => {
        seconds--;
        countdown.innerText = seconds;

        if (seconds <= 0) {
            clearInterval(interval);
            btn.disabled = false;
            btn.innerText = "Resend OTP";
        }
    }, 1000);
</script>

    </div>

</div>

</x-auth.layout>