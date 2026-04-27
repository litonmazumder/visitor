<x-auth.layout title="Password Reset">

    <div class="card-body login-card-body">
      <p class="login-box-msg">Reset Password</p>
      <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">
    
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        <button type="submit">Reset Password</button>
    </form>    
      <p class="mb-1 pt-2">
        <a href="{{ route('login') }}">Login</a>
      </p>      
      
    </div>
  
  </x-auth.layout>