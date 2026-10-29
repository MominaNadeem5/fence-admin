
@extends('admin.layout')

@section('title', 'Website Content')
@section('topbar-title', 'Website Content')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">WEBSITE SETTINGS</div>
            <h1>Manage Your Website</h1>
            <p>Update the content visitors see on your homepage.</p>
        </div>

        <a href="{{ url('/') }}" target="_blank" class="button button-light">
            ↗ &nbsp; Preview Website
        </a>
    </div>

    <form
        action="{{ route('admin.website-content.update') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method('PUT')

        {{-- Brand Identity --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>Brand Identity</h2>
                    <p>Your business name and main tagline.</p>
                </div>
                <span class="stat-icon">✦</span>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="brand_name">Business / Brand Name *</label>
                    <input
                        id="brand_name"
                        name="brand_name"
                        value="{{ old('brand_name', $settings->brand_name ?? '') }}"
                        placeholder="e.g. ABC Fencing"
                        required
                    >
                </div>

                <div class="field">
                    <label for="tagline">Brand Tagline *</label>
                    <input
                        id="tagline"
                        name="tagline"
                        value="{{ old('tagline', $settings->tagline ?? '') }}"
                        placeholder="A short line about your business"
                        required
                    >
                </div>
            </div>
        </div>

        {{-- Business Branding and SEO --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>Business Branding &amp; SEO</h2>
                    <p>Upload your logo, set your favicon and improve search engine information.</p>
                </div>
                <span class="stat-icon">◎</span>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="logo">Business Logo</label>
                    <input
                        id="logo"
                        type="file"
                        name="logo"
                        accept=".png,.jpg,.jpeg,.webp"
                    >
                    <div class="hint">PNG, JPG or WEBP. Maximum size: 2 MB.</div>

                    @if (!empty($settings->logo_path))
                        <div style="margin-top:12px">
                            <p>Current logo:</p>
                            <img
                                src="{{ asset('storage/' . $settings->logo_path) }}"
                                alt="Current business logo"
                                style="max-width:180px;max-height:100px;object-fit:contain"
                            >
                        </div>
                    @endif
                </div>

                <div class="field">
                    <label for="favicon">Website Favicon</label>
                    <input
                        id="favicon"
                        type="file"
                        name="favicon"
                        accept=".ico,.png,.jpg,.jpeg,.webp"
                    >
                    <div class="hint">ICO, PNG, JPG or WEBP. Maximum size: 1 MB.</div>

                    @if (!empty($settings->favicon_path))
                        <div style="margin-top:12px">
                            <p>Current favicon:</p>
                            <img
                                src="{{ asset('storage/' . $settings->favicon_path) }}"
                                alt="Current website favicon"
                                style="width:40px;height:40px;object-fit:contain"
                            >
                        </div>
                    @endif
                </div>

                <div class="field full">
                    <label for="seo_title">Website SEO Title</label>
                    <input
                        id="seo_title"
                        name="seo_title"
                        value="{{ old('seo_title', $settings->seo_title ?? '') }}"
                        placeholder="ABC Fencing | Quality Fences"
                        maxlength="255"
                    >
                    <div class="hint">
                        The title that can appear in browser tabs and search results.
                    </div>
                </div>

                <div class="field full">
                    <label for="seo_description">SEO Description</label>
                    <textarea
                        id="seo_description"
                        name="seo_description"
                        rows="3"
                        maxlength="1000"
                        placeholder="Describe your business and services for search engines"
                    >{{ old('seo_description', $settings->seo_description ?? '') }}</textarea>
                    <div class="hint">
                        Write a short, clear description of your business and services.
                    </div>
                </div>
            </div>
        </div>

        {{-- Homepage Hero Section --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>Homepage Hero Section</h2>
                    <p>The first message visitors see when they arrive.</p>
                </div>
                <span class="stat-icon">⌂</span>
            </div>

<div class="field">
    <label for="hero_image">Hero Background Image</label>

    @if (!empty($settings->hero_image_path))
        <div style="margin-bottom: 12px;">
            <img
                src="{{ asset('storage/' . $settings->hero_image_path) }}"
                alt="Current hero background"
                style="width: 100%; max-width: 500px; height: 180px; object-fit: cover; border-radius: 8px;"
            >
            <p style="margin-top: 6px;">Current background image</p>
        </div>
    @endif

    <input
        type="file"
        id="hero_image"
        name="hero_image"
        accept=".jpg,.jpeg,.png,.webp"
    >

    <small>JPG, PNG, or WebP. Maximum size: 5 MB.</small>
</div>

            <div class="form-grid">
                <div class="field full">
                    <label for="hero_title">Main Homepage Heading *</label>
                    <input
                        id="hero_title"
                        name="hero_title"
                        value="{{ old('hero_title', $settings->hero_title ?? '') }}"
                        placeholder="Your main homepage heading"
                        required
                    >
                </div>

                <div class="field full">
                    <label for="hero_subtitle">Homepage Description *</label>
                    <textarea
                        id="hero_subtitle"
                        name="hero_subtitle"
                        placeholder="Describe your services to visitors"
                        required
                    >{{ old('hero_subtitle', $settings->hero_subtitle ?? '') }}</textarea>
                    <div class="hint">
                        Keep this clear, helpful and easy to understand.
                    </div>
                </div>
            </div>
        </div>

{{-- Hero Buttons Settings --}}
<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Homepage Buttons</h2>
            <p>Change the text and destination of both hero buttons.</p>
        </div>
        <span class="stat-icon">↗</span>
    </div>

    <div class="form-grid">
        <div class="field">
            <label for="hero_primary_button_text">Primary Button Text</label>
            <input
                id="hero_primary_button_text"
                name="hero_primary_button_text"
                value="{{ old('hero_primary_button_text', $settings->hero_primary_button_text ?? 'Request a Free Quote') }}"
                placeholder="Request a Free Quote"
            >
        </div>

        <div class="field">
            <label for="hero_primary_button_url">Primary Button Link</label>
            <input
                id="hero_primary_button_url"
                name="hero_primary_button_url"
                value="{{ old('hero_primary_button_url', $settings->hero_primary_button_url ?? '#contact') }}"
                placeholder="#contact"
            >
        </div>

        <div class="field">
            <label for="hero_secondary_button_text">Secondary Button Text</label>
            <input
                id="hero_secondary_button_text"
                name="hero_secondary_button_text"
                value="{{ old('hero_secondary_button_text', $settings->hero_secondary_button_text ?? 'Explore Our Services') }}"
                placeholder="Explore Our Services"
            >
        </div>

        <div class="field">
            <label for="hero_secondary_button_url">Secondary Button Link</label>
            <input
                id="hero_secondary_button_url"
                name="hero_secondary_button_url"
                value="{{ old('hero_secondary_button_url', $settings->hero_secondary_button_url ?? '#services') }}"
                placeholder="#services"
            >
        </div>
    </div>
</div>

{{-- Homepage Statistics Settings --}}
<div class="panel">
    <div class="panel-header">
        <div>
            <h2>Homepage Statistics</h2>
            <p>These statistics will appear below the homepage banner.</p>
        </div>
        <span class="stat-icon">▥</span>
    </div>

    <div class="form-grid">
        <div class="field">
            <label for="stat_1_value">Statistic 1 Value</label>
            <input
                id="stat_1_value"
                name="stat_1_value"
                value="{{ old('stat_1_value', $settings->stat_1_value ?? '500+') }}"
                placeholder="500+"
            >
        </div>

        <div class="field">
            <label for="stat_1_label">Statistic 1 Label</label>
            <input
                id="stat_1_label"
                name="stat_1_label"
                value="{{ old('stat_1_label', $settings->stat_1_label ?? 'Products') }}"
                placeholder="Products"
            >
        </div>

        <div class="field">
            <label for="stat_2_value">Statistic 2 Value</label>
            <input
                id="stat_2_value"
                name="stat_2_value"
                value="{{ old('stat_2_value', $settings->stat_2_value ?? '50+') }}"
                placeholder="50+"
            >
        </div>

        <div class="field">
            <label for="stat_2_label">Statistic 2 Label</label>
            <input
                id="stat_2_label"
                name="stat_2_label"
                value="{{ old('stat_2_label', $settings->stat_2_label ?? 'Countries') }}"
                placeholder="Countries"
            >
        </div>

        <div class="field">
            <label for="stat_3_value">Statistic 3 Value</label>
            <input
                id="stat_3_value"
                name="stat_3_value"
                value="{{ old('stat_3_value', $settings->stat_3_value ?? '10,000+') }}"
                placeholder="10,000+"
            >
        </div>

        <div class="field">
            <label for="stat_3_label">Statistic 3 Label</label>
            <input
                id="stat_3_label"
                name="stat_3_label"
                value="{{ old('stat_3_label', $settings->stat_3_label ?? 'Happy Clients') }}"
                placeholder="Happy Clients"
            >
        </div>
    </div>
</div>

        {{-- About Section --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>About Section</h2>
                    <p>Tell visitors about your business and service.</p>
                </div>
                <span class="stat-icon">▤</span>
            </div>

            <div class="form-grid">
                <div class="field full">
                    <label for="about_title">About Section Heading *</label>
                    <input
                        id="about_title"
                        name="about_title"
                        value="{{ old('about_title', $settings->about_title ?? '') }}"
                        placeholder="About your business"
                        required
                    >
                </div>

                <div class="field full">
                    <label for="about_text">About Section Description *</label>
                    <textarea
                        id="about_text"
                        name="about_text"
                        placeholder="Write about your business"
                        required
                    >{{ old('about_text', $settings->about_text ?? '') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Contact Information --}}
        <div class="panel">
            <div class="panel-header">
                <div>
                    <h2>Contact Information</h2>
                    <p>Keep your business contact details up to date.</p>
                </div>
                <span class="stat-icon">☎</span>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="phone">Phone Number</label>
                    <input
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $settings->phone ?? '') }}"
                        placeholder="Your business phone"
                    >
                </div>

                <div class="field">
                    <label for="email">Business Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email', $settings->email ?? '') }}"
                        placeholder="you@example.com"
                    >
                </div>

                <div class="field full">
                    <label for="address">Business Address / Service Area</label>
                    <input
                        id="address"
                        name="address"
                        value="{{ old('address', $settings->address ?? '') }}"
                        placeholder="Your city or service area"
                    >
                </div>
            </div>

            <div class="form-footer">
                <span style="color:#8791a5;font-size:12px">
                    Changes are saved to your database.
                </span>

                <button type="submit" class="button">
                    ✓ &nbsp; Save Changes
                </button>
            </div>
        </div>
    </form>
@endsection
