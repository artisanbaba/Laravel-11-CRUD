@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <a href="{{ route('products.index') }}" class="btn btn-dark mb-3">← Back to Products</a>

                <div class="card shadow-lg">
                    <div class="card-header bg-dark text-white">
                        <h3>Product Details</h3>
                    </div>

                    <div class="card-body">

                        @if ($product->image)
                            <div class="text-center mb-3">
                                <img src="{{ asset('uploads/products/' . $product->image) }}" 
                                    width="200" 
                                    class="img-thumbnail">
                            </div>
                        @endif

                        <h4>Name: {{ $product->name }}</h4>
                        <p><strong>SKU:</strong> {{ $product->sku }}</p>
                        <p><strong>Price:</strong> ${{ $product->price }}</p>
                        <p><strong>Description:</strong> {{ $product->description }}</p>

                        <p><strong>Created At:</strong> 
                            {{ \Carbon\Carbon::parse($product->created_at)->format('d M, Y') }}
                        </p>

                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-dark">Edit</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
