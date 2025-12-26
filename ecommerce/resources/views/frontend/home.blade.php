@extends('layouts.app')

@section('content')
<h2 class="text-2xl font-bold mb-6">Latest Products</h2>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div class="bg-white p-4 rounded shadow">
        <div class="h-40 bg-gray-200 mb-3"></div>
        <h3 class="font-semibold">Product Name</h3>
        <p class="text-gray-500">₹999</p>
        <button class="mt-3 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
            Add to Cart
        </button>
    </div>
</div>
@endsection
