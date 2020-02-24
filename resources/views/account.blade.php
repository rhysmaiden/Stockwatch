@extends('layouts.app')

@section('content')
    <div class="user-account">
        <h2>Account Settings</h2>

        <div class="profile-image-edit">
            <img src="{{ asset('/storage/avatar-default.svg') }}" title="Profile image" class="profile-pic" />

            <div class="image-edit-button">
                <button type="submit" class="button-base secondary ghost mg-btm-sm">
                    {{ __('Upload Photo') }}
                </button>
                <p>image requirements</p>
            </div>
        </div>

        <div class="edit-profile">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                    <label for="name" class="label">{{ __('Display Name') }}</label>
                    <input id="name" type="text" class="mg-btm-md text-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Full name') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="username" class="label">{{ __('Username') }}</label>
                    <input id="name" type="text" class="mg-btm-md text-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="{{ __('Username') }}">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="email" class="label">{{ __('E-Mail Address') }}</label>
                    <input disabled id="email" type="email" class="mg-btm-md text-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Email address') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror


                    <button type="submit" class="button-base secondary mg-top-lg mg-btm-lg">
                        {{ __('Save changes') }}
                    </button>
                </form>
</div>
    </div>
@endsection