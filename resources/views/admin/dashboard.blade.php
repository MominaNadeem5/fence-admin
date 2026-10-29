@extends('admin.layout')

@section('title', 'Dashboard')
@section('topbar-title', 'Dashboard Overview')

@section('content')
    <div class="page-heading">
        <div>
            <div class="eyebrow">Your workspace</div>
            <h1>Welcome back, {{ auth()->user()->name }}</h1>
            <p>Here is an overview of your website content.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="button">+ Add Product</a>
    </div>

    <div class="stats">
        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">Products</span>
                <span class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 8l-9-5-9 5v8l9 5 9-5zM3 8l9 5 9-5M12 13v8"/></svg>
                </span>
            </div>
            <h3>{{ number_format($stats['products']) }}</h3>
            <p>{{ number_format($stats['active_products']) }} visible on the website</p>
        </div>

        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">Categories</span>
                <span class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                </span>
            </div>
            <h3>{{ number_format($stats['categories']) }}</h3>
            <p>{{ number_format($stats['active_categories']) }} visible on the website</p>
        </div>

        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">Services</span>
                <span class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                </span>
            </div>
            <h3>{{ number_format($stats['services']) }}</h3>
            <p>Active on the homepage</p>
        </div>

        <div class="stat">
            <div class="stat-top">
                <span class="stat-label">Admins</span>
                <span class="stat-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/></svg>
                </span>
            </div>
            <h3>{{ number_format($stats['admins']) }}</h3>
            <p>Accounts with admin access</p>
        </div>
    </div>

    @if ($uncategorizedCount > 0)
        <div class="alert alert-error" role="status">
            {{ $uncategorizedCount }} {{ \Illuminate\Support\Str::plural('product', $uncategorizedCount) }} {{ $uncategorizedCount === 1 ? 'has' : 'have' }} no category.
            <a href="{{ route('admin.products.index', ['category' => 'none']) }}" style="text-decoration:underline">Review them</a>
        </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>Recent products</h2>
                <p>The five most recently added products.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="button button-light button-sm">View all</a>
        </div>

        @if ($recentProducts->isEmpty())
            <div class="empty">
                <strong>No products yet</strong>
                <p>Add your first product to show it on the website.</p>
                <a href="{{ route('admin.products.create') }}" class="button">+ Add Product</a>
            </div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentProducts as $product)
                            <tr>
                                <td><a href="{{ route('admin.products.edit', $product) }}"><strong>{{ $product->name }}</strong></a></td>
                                <td>{{ $product->category?->name ?? 'Uncategorized' }}</td>
                                <td>{{ number_format((float) $product->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $product->is_active ? 'badge-success' : 'badge-muted' }}">
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $product->created_at?->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="panel">
        <div class="panel-header">
            <div>
                <h2>Quick actions</h2>
                <p>Jump straight to the task you want to complete.</p>
            </div>
        </div>

        <div class="quick-grid">
            <a href="{{ route('admin.website-content.edit') }}" class="quick-link">
                <span class="quick-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9M16.5 3.5a2.1 2.1 0 013 3L7 19l-4 1 1-4z"/></svg>
                </span>
                <span>
                    <strong>Edit homepage content</strong>
                    <small>Title, tagline, contact details and services</small>
                </span>
            </a>

            <a href="{{ route('admin.categories.create') }}" class="quick-link">
                <span class="quick-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 7a2 2 0 012-2h4l2 2h8a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
                </span>
                <span>
                    <strong>Add a category</strong>
                    <small>Organise your products</small>
                </span>
            </a>

            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="quick-link">
                <span class="quick-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 010 18M12 3a14 14 0 000 18"/></svg>
                </span>
                <span>
                    <strong>Preview website</strong>
                    <small>Open the public homepage in a new tab</small>
                </span>
            </a>

            <a href="{{ route('admin.register') }}" class="quick-link">
                <span class="quick-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 3l8 3v6c0 4.5-3.2 8-8 9-4.8-1-8-4.5-8-9V6z"/></svg>
                </span>
                <span>
                    <strong>Add another admin</strong>
                    <small>Give a colleague admin access</small>
                </span>
            </a>
        </div>
    </div>
@endsection
