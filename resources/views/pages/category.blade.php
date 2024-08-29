@extends('layouts.header')
@section('content')

<div class="flex p-4 bg-gray-300 text-white">
    <div class="bg-white p-2 rounded-xl border border-gray-400">
        <i class="text-black fa-solid fa-list"></i>
        <select name="category" class="text-black bg-transparent focus:outline-none">
            @foreach($currentCategory as $category)
                <option class="text-red-500 font-semibold" value="{{ $category->id }}">{{ $category->title }}
                </option>
            @endforeach
            @foreach($categories as $category)
                <option class="text-black" value="{{ $category->id }}">{{ $category->title }}</option>
            @endforeach
        </select>
    </div>

</div>

@endsection