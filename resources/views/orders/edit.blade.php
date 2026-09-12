@extends('layouts.app')

@section('title', 'Edit Order')

@section('breadcrumb')
<a href="{{ route('dashboard.index') }}">Dashboard</a>
<span class="sep">/</span>
<a href="{{ route('orders.index') }}">Orders</a>
<span class="sep">/</span>
<span class="current">Edit Order</span>
@endsection

@section('content')
<div class="form-page">
    <div class="page-header">
        <h4><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Order</h4>
        <a href="{{ route('orders.index') }}" class="btn btn-light btn-sm">
            <i class="bi bi-arrow-left me-1"></i>Back to Orders
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger d-flex align-items-start gap-2" role="alert">
            <i class="bi bi-exclamation-triangle-fill mt-1"></i>
            <div>
                <strong>Something went wrong.</strong> Please fix the errors below and try again.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="app-card form-card">
        <div class="app-card-header">
            <h6 class="mb-0"><i class="bi bi-cart-check me-2 text-primary"></i>Order Information</h6>
        </div>
        <div class="app-card-body">
            <form action="{{ route('orders.update', $order->id) }}" method="POST" data-loading>
                @csrf
                @method('PUT')

                <div class="form-section">
                    <div class="form-section-title">
                        <span class="section-icon"><i class="bi bi-person"></i></span>
                        Customer & Item
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="customer_name" class="form-label">Customer Name <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-person"></i>
                                <input type="text" id="customer_name" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}" class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}" placeholder="e.g. John Smith" required>
                            </div>
                            @if ($errors->has('customer_name'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('customer_name') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="item_id" class="form-label">Select Item <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-box-seam"></i>
                                <select name="item_id" id="item_id" class="form-select {{ $errors->has('item_id') ? 'is-invalid' : '' }}" required>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" {{ old('item_id', $order->item_id) == $item->id ? 'selected' : '' }}>{{ $item->name }} — ${{ number_format($item->price, 2) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('item_id'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('item_id') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="quantity" class="form-label">Quantity <span class="text-danger">*</span></label>
                            <div class="input-icon">
                                <i class="bi bi-sort-numeric-up"></i>
                                <input type="number" name="quantity" id="quantity" min="1" value="{{ old('quantity', $order->quantity) }}" class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" placeholder="e.g. 3" required>
                            </div>
                            @if ($errors->has('quantity'))
                                <div class="error-text"><i class="bi bi-exclamation-circle"></i>{{ $errors->first('quantity') }}</div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <div class="input-icon">
                                <i class="bi bi-flag"></i>
                                <select name="status" id="status" class="form-select">
                                    <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="completed" {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-lg me-1"></i>Update Order
                    </button>
                    <a href="{{ route('orders.index') }}" class="btn btn-light border">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection