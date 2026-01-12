@extends('layouts.admin')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-semibold mb-4">Import Categories</h2>

    <form action="{{ route('admin.categories.import.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf

        <input type="file" name="file" required
               class="block w-full border p-2 rounded">

        <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
            Upload & Import
        </button>
    </form>
</div>
@endsection
