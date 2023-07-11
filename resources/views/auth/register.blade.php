@extends('layouts.auth')

@section('title', 'Masuk | Sistem Pakar Honda Vario 125')

@section('content')
<div class="vh-100 d-flex justify-content-center align-items-center" id="hero">
  <div class="card p-4 py-5 login__form" style="width: 25em;">
    <div class="text-center login__form-header mb-4">
      <h1>Registrasi</h1>
    </div>
    <form class="user" method="POST" action="{{route('register.proses')}}" class="py-5">
      @csrf
      @if ($errors->has('message'))  
        <p class="text-center text-danger">{{$errors->first('message') }}</p>
      @endif
     
      <div class="form-group mb-3">
          <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('name') }}" name="name" value="{{ old('name') }}" required autofocus>
                          
          @if ($errors->has('name'))
              <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('name') }}</strong>
              </span>
          @endif
      </div>
      <div class="form-group mb-3">
        <input class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" placeholder="{{ __('Username') }}" name="username" value="{{ old('username') }}" required autofocus>
                        
        @if ($errors->has('username'))
            <span class="invalid-feedback" style="display: block;" role="alert">
                <strong>{{ $errors->first('username') }}</strong>
            </span>
        @endif
    </div>
      <div class="form-group mb-3">
          <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required>
                          
          @if ($errors->has('password'))
              <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('password') }}</strong>
              </span>
          @endif
      </div>
      <div class="form-group">
          <input class="form-control{{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" type="password" required>
                          
          @if ($errors->has('password_confirmation'))
              <span class="invalid-feedback" style="display: block;" role="alert">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
              </span>
          @endif
      </div>
      
      <button class="mt-4 btn btn-primary w-100">Register</button>
    </form>
  </div>
</div>
    
@endsection
