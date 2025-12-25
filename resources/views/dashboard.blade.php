@extends('layouts.app')

@section('title','Dashboard - BIOMED')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-xl font-bold">Dashboard - <span class="capitalize">{{ $role }}</span></h2>
    <form method="POST" action="{{ route('role.clear') }}">
        @csrf
        <button class="text-sm text-red-600 hover:underline">Clear Role</button>
    </form>
</div>

<ul class="space-y-4">
    @foreach($cards as $card)
    <li class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 flex items-center gap-4">
        <!-- Left icon box -->
        <div class="flex-shrink-0">
            <div class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/30 rounded-md flex items-center justify-center text-indigo-600 dark:text-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M3 7a1 1 0 011-1h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7z" />
                </svg>
            </div>
        </div>

        <!-- Dots center -->
        <div class="hidden sm:flex flex-col items-center justify-center gap-1">
            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
            <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
        </div>

        <!-- Text -->
        <div class="flex-1">
            <h3 class="font-semibold">{{ $card['title'] }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-300">{{ $card['desc'] }}</p>
        </div>

        <div>
            <a href="#" class="text-indigo-600 hover:underline text-sm">Open</a>
        </div>
    </li>
    @endforeach
</ul>

@endsection