<x-auth.layout title="Forgot Password">
<div class="card-body">
    <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
    <form action="{{ route('password.reset') }}" method="post">
      @csrf
      <div class="input-group mb-3">
        <input type="email" class="form-control" placeholder="Email" name="email" required>
        <div class="input-group-append">
          <div class="input-group-text">
            <span class="fa fa-envelope">@</span>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
        </div>
        <!-- /.col -->
      </div>
    </form>
    <p class="mt-3 mb-1">
      <a href="{{ route('login') }}">Login</a>
    </p>
  </div>
</x-auth.layout>