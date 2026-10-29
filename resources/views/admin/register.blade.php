@extends('admin.layout')

@section('title', 'Add Admin')
@section('topbar-title', 'Add Admin')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Access control</div>
            <h1>Add admin</h1>
            <p>Only signed-in admins can create other admin accounts. Public registration is disabled.</p>
        </div>
    </div>

    <div class="panel" style="max-width: 720px;">
        <form method="POST" action="{{ route('admin.register') }}" autocomplete="off">
            @csrf

            <div class="form-grid">
                <div class="field full">
                    <label for="name">Full name *</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required>
                    @error('name') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="field full">
                    <label for="email">Email address *</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
                    @error('email') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password">Password *</label>
                    <input id="password" type="password" name="password" minlength="8"
                           autocomplete="new-password"
                           class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required>
                    <div class="hint">At least 8 characters.</div>
                    @error('password') <span class="error-text">{{ $message }}</span> @enderror
                </div>

                <div class="field">
                    <label for="password_confirmation">Confirm password *</label>
                    <input id="password_confirmation" type="password" name="password_confirmation"
                           minlength="8" autocomplete="new-password" required>
                </div>
            </div>

            <div class="form-footer">
                <a href="{{ route('admin.dashboard') }}" class="button button-light">Cancel</a>
                <button type="submit" class="button">Create admin</button>
            </div>
        </form>
    </div>
@endsection
