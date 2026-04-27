<x-auth.layout title="Login">

<div class="card-body login-card-body">

    <p class="login-box-msg">Sign in to Dashboard</p>

    {{-- OTP FORM (DEFAULT) --}}
    <!-- <form method="POST" action="{{route('check.email')}}" id="otpForm">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="Enter your email" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-block">
            Continue (Send OTP)
        </button>
    </form> -->

    {{-- PASSWORD FORM (HIDDEN) --}}
     <form method="POST" action="{{route('login.submit')}}" id="passwordForm">
        @csrf

        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control"
                   placeholder="Email" required>
        </div>

        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control"
                   placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-dark btn-block">
            Login
        </button>
    </form>

    {{-- TOGGLE LINK --}}
    <!-- <p class="mt-3 text-center">
        <a href="#" id="toggleLogin">Login with password</a>
    </p> -->

</div> 

</x-auth.layout>

{{-- JS Toggle --}}
<!-- <script>
    const toggle = document.getElementById('toggleLogin');
    const otpForm = document.getElementById('otpForm');
    const passwordForm = document.getElementById('passwordForm');

    toggle.addEventListener('click', function(e) {
        e.preventDefault();

        if (passwordForm.style.display === 'none') {
            otpForm.style.display = 'none';
            passwordForm.style.display = 'block';
            toggle.innerText = 'Login with OTP';
        } else {
            otpForm.style.display = 'block';
            passwordForm.style.display = 'none';
            toggle.innerText = 'Login with password';
        }
    });
</script> -->