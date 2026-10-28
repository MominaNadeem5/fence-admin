
@extends('admin.layout')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard Overview')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">YOUR WORKSPACE</div>
            <h1>Welcome back, Admin 👋</h1>
            <p>Here is your website management overview.</p>
        </div>
        <a href="{{ route('admin.website-content.edit') }}" class="button">
            ✎ &nbsp; Edit Website
        </a>
    </div>

    <div class="welcome-card">
        <div>
            <div class="eyebrow" style="color:#c6d8f5">FENCE ADMINISTRATION</div>
            <h2>Your website. Your control.</h2>
            <p>Update your homepage messaging and business details<br>
            from one simple, secure workspace.</p>
            <div style="margin-top:22px">
                <a href="{{ route('admin.website-content.edit') }}"
                   class="button" style="background:white;color:#173b70">
                    Manage Website Content &nbsp; →
                </a>
            </div>
        </div>
        <div class="welcome-symbol">⌂</div>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">ADMIN STATUS</span>
                <span class="stat-icon">🛡️</span>
            </div>
            <h3>Active</h3>
            <p>Your admin access is enabled.</p>
        </div>

        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">WEBSITE CONTENT</span>
                <span class="stat-icon">✎</span>
            </div>
            <h3>Manage</h3>
            <p>Edit titles, descriptions and contact details.</p>
        </div>

        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">WEBSITE STATUS</span>
                <span class="stat-icon">🌐</span>
            </div>
            <h3>Ready</h3>
            <p>Open your website to preview changes.</p>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>Quick Actions</h2>
                <p>Jump straight to the task you want to complete.</p>
            </div>
        </div>

        <div class="quick-grid">
            <a href="{{ route('admin.website-content.edit') }}" class="quick-link">
                <span class="quick-icon">📝</span>
                <span>
                    <strong>Edit Homepage Content</strong>
                    <small>Change your title, tagline and descriptions</small>
                </span>
            </a>

            <a href="{{ url('/') }}" target="_blank" class="quick-link">
                <span class="quick-icon">🌐</span>
                <span>
                    <strong>Preview Website</strong>
                    <small>Open the current public homepage</small>
                </span>
            </a>
        </div>
    </div>
@endsection
