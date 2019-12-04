@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('User') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

<form action="{{ url('user/store') }}" method="post">
     @csrf
  <div class="form-group">
    <label for="name">{{ __('Name') }}</label>
    <input
        type="text"
        name="name"
        class="form-control"
        id="name"
        value="{{ old('name') }}"
        placeholder="{{ __('Enter name') }}">
    <span class="text-danger">{{ $errors->first('name') }}</span>
  </div>
  <div class="form-group">
    <label for="email">Email</label>
    <input
        type="text"
        name="email"
        class="form-control"
        id="email"
        value=""
        placeholder="{{ __('Enter email') }}">
    <span class="text-danger">{{ $errors->first('email') }}</span>
  </div>
  <div class="form-group">
    <label for="password">{{ __('Password') }}</label>
    <input
        type="password"
        name="password"
        class="form-control"
        id="password"
        placeholder="{{ __('Enter password') }}">
    <span class="text-danger">{{ $errors->first('password') }}</span>
  </div>
  <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
