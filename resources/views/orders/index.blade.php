@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div class="page-header">
    <h4><i class="bi bi-cart-check me-2 text-primary"></i>Orders</h4>
    <div class="page-header-actions">
        <a href="{{ route('orders.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg me-1"></i>Add Order
        </a>
    </div>
</div>

<div class="app-card">
    <div class="app-card-header">
        <h6 class="mb-0">All Orders <small class="text-muted fw-normal">({{ $orders->count() }})</small></h6>
    </div>

    <div class="app-card-body">
        <div class="table-scroll-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width:60px;">#</th>
                        <th>Customer</th>
                        <th>Item</th>
                        <th>Qty</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th style="width:140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td><span class="text-muted">#{{ $order->id }}</span></td>
                            <td>
                                <span class="fw-semibold">{{ $order->customer_name }}</span>
                            </td>
                            <td>
                                {{ $order->item->name ?? 'Item Deleted' }}
                            </td>
                            <td>{{ $order->quantity }}</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="status-badge pending">
                                        <span class="status-dot"></span>Pending
                                    </span>
                                @else
                                    <span class="status-badge completed">
                                        <span class="status-dot"></span>Completed
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted">{{ $order->created_at->diffForHumans() }}</td>
                            <td>
                                <div class="table-actions">
                                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary btn-sm" title="Edit order">
                                        <i class="bi bi-pencil-square me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm" data-delete-form data-item-name="Order #{{ $order->id }}" title="Delete order">
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
                                    <div class="empty-icon"><i class="bi bi-cart-x"></i></div>
                                    <h6>No orders yet</h6>
                                    <p>Start by creating your first order.</p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-plus-lg me-1"></i>Create Order
                                    </a>
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
