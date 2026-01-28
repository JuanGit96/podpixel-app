@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Registrar Nueva Ciudad</h2>
    
    <form action="{{ route('cities.store') }}" method="POST" enctype="multipart/form-data">
        @include('cities.form', ['btnText' => 'Guardar Ciudad'])
    </form>
</div>
@endsection