@extends('layouts.app')

@section('title', 'Inventory Items')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #eff6ff, #dbeafe); color: #2563eb;">
                <i class="bi bi-box-seam"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Items</div>
                <div class="stat-value"><span class="counter" data-target="{{ $items->count() }}">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ecfdf5, #d1fae5); color: #059669;">
                <i class="bi bi-archive"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Stock</div>
                <div class="stat-value"><span class="counter" data-target="{{ $items->sum('quantity') }}">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: #d97706;">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Value</div>
                <div class="stat-value">$<span class="counter" data-target="{{ $items->sum(function($i){ return $i->price; }) }}" data-decimals="2">0</span></div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fef2f2, #fecaca); color: #dc2626;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Pending Orders</div>
                <div class="stat-value"><span class="counter" data-target="{{ \App\Models\Order::where('status', 'pending')->count() }}">0</span></div>
            </div>
        </div>
    </div>
</div>

<div class="app-card mb-4">
    <div class="app-card-header">
        <form method="GET" action="{{ route('items.index') }}" class="d-flex flex-grow-1" style="max-width:420px;">
            <div class="search-bar flex-grow-1">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search items by name...">
                @if(request('search'))
                    <a href="{{ route('items.index') }}" class="clear-search" title="Clear search">
                        <i class="bi bi-x-lg"></i>
                    </a>
                @endif
            </div>
            <button class="btn btn-primary ms-2" type="submit">
                <i class="bi bi-search d-sm-none"></i>
                <span class="d-none d-sm-inline">Search</span>
            </button>
        </form>
        <div class="page-header-actions">
            <a href="{{ route('items.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg me-1"></i>Add Item
            </a>
        </div>
    </div>

    <div class="app-card-body">
        <div class="table-scroll-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th style="width:150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td><span class="text-muted">#{{ $item->id }}</span></td>
                            <td>
                                <span class="fw-semibold">{{ $item->name }}</span>
                                @if($item->category)
                                    <br><small class="text-muted">{{ $item->category }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->quantity < 5)
                                    <span class="badge bg-danger bg-opacity-10 text-danger">{{ $item->quantity }}</span>
                                @else
                                    {{ $item->quantity }}
                                @endif
                            </td>
                            <td class="fw-semibold">${{ number_format($item->price, 2) }}</td>
                            <td>
                                <span class="text-muted" style="max-width:200px; display:inline-block; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                                    {{ $item->description ?: '—' }}
                                </span>
                            </td>
                            <td>
                                @if($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->name }}" class="table-thumb">
                                @else
                                    <div class="table-thumb-placeholder">
                                        <i class="bi bi-image"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-primary btn-sm" title="Edit item">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" data-delete-form data-item-name="{{ $item->name }}" title="Delete item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <div class="empty-icon"><i class="bi bi-box-seam"></i></div>
                                    <h6>No items found</h6>
                                    <p>{{ request('search') ? 'No items match your search. Try a different keyword.' : 'Get started by adding your first inventory item.' }}</p>
                                    @if(!request('search'))
                                        <a href="{{ route('items.create') }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Add First Item
                                        </a>
                                    @else
                                        <a href="{{ route('items.index') }}" class="btn btn-outline-secondary btn-sm">Clear Search</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
