@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('New Section') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

<form action="{{ url('section/store') }}" method="post" enctype="multipart/form-data">
     @csrf
  <div class="form-group">
    <label for="name">{{ __('Section name') }}</label>
    <input
        type="text"
        name="name"
        class="form-control"
        id="name"
        value="{{ old('name') }}"
        placeholder="{{ __('Enter section name') }}">
    <span class="text-danger">{{ $errors->first('name') }}</span>
  </div>
  <div class="form-group">
    <label for="description">{{ __('Description') }}</label>
    <textarea class="form-control" id="description" name="description" rows="3" placeholder="{{ __('Enter description') }}">{{ old('description') }}</textarea>
    <span class="text-danger">{{ $errors->first('description') }}</span>
  </div>

  <div class="form-group">
    <label for="description">{{ __('Logo') }}</label>
    <div class="custom-file">
      <input type="file" name="fileToUpload" class="custom-file-input" id="customFile">
      <label class="custom-file-label" for="customFile">{{ __('Choose file') }}</label>
    </div>
    <span class="text-danger">{{ $errors->first('fileToUpload') }}</span>
</div>



  <div class="form-group">
      <h3>{{ __('Users') }}</h3>
      @foreach($users as $user)
      <div class="custom-control custom-checkbox">
          <input
            type="checkbox"
            class="custom-control-input"
            id="chbx{{ $user->id }}"
            name="users[]"
            value="{{ $user->id }}">
          <label class="custom-control-label" for="chbx{{ $user->id }}">
              {{ $user->name }} (<a href="mailto:{{ $user->email }}">{{ $user->email }}</a>)
          </label>
      </div>
      @endforeach
  </div>

  <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
</form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
