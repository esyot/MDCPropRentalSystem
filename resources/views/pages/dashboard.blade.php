@extends('layouts.header')
@section('content')
<div id="content" class="flex items-center justify-between bg-gradient-to-r from-cyan-500 to-cyan-800 p-4 shadow-md">
    <div class="flex items-center space-x-2">
        <form id="filter-form" class="flex justify-around space-x-4" action="{{ route('dateCustom')}}" method="GET">
            @csrf
            @foreach($currentCategory as $category)
                <a href="{{ route('calendarMove', ['action'=> 'left', 'category'=> $category->id, 'year'=> $currentDate->format('Y'), 'month'=>$currentDate->format('n')])}}">
                    <i class="shadow-md text-white fa-solid fa-chevron-left hover:text-blue-300 cursor-pointer bg-blue-500 w-10 h-10 flex items-center justify-center rounded-full transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                </a>
            @endforeach
            @foreach($currentCategory as $category)
                <a href="{{ route('calendarMove', ['action'=> 'right', 'category'=> $category->id, 'year'=> $currentDate->format('Y'), 'month'=>$currentDate->format('n')])}}">
                    <i class="shadow-md text-white fa-solid fa-chevron-right hover:text-blue-300 cursor-pointer bg-blue-500 w-10 h-10 flex items-center justify-center rounded-full transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                </a>
            @endforeach
            <select name="month" class="shadow-inner block px-4 py-2 border border-gray-500 rounded">
                <option value="{{ $currentDate->format('n') }}">{{ $currentDate->format('F') }}</option>
                <option value="1">January</option>
                <option value="2">February</option>
                <option value="3">March</option>
                <option value="4">April</option>
                <option value="5">May</option>
                <option value="6">June</option>
                <option value="7">July</option>
                <option value="8">August</option>
                <option value="9">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>

            <select name="year" class="block shadow-inner px-4 py-2 border border-gray-500 rounded">
                <option value="{{ $currentDate->format('Y') }}">{{ $currentDate->format('Y') }}</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
                <option value="2027">2027</option>
                <option value="2028">2028</option>
                <option value="2029">2029</option>
                <option value="2030">2030</option>
            </select>

            <select name="category" class="shadow-inner block px-4 py-2 border border-gray-500 rounded">
                @foreach($currentCategory as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>

            </form>
    </div>
</div>

<div id="modal-item"></div>

<div class="p-6 bg-gray-100 flex-1 overflow-auto bg-gray-800 bg-opacity-50 w-full h-screen">
<div id="calendar-grid" class="grid grid-cols-7 gap-2 bg-white p-2 h-full">

        <!-- Header with days of the week (static) -->
        <div class="rounded-t-lg calendar-cell bg-red-500 p-2 flex items-center justify-center font-semibold text-gray-100">Sun</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Mon</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Tue</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Wed</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Thu</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Fri</div>
        <div class="rounded-t-lg calendar-cell bg-gray-500 p-2 flex items-center justify-center font-semibold text-gray-100">Sat</div>

        <!-- Calculate the starting position of the first day -->
        @php
            $firstDayOfMonth = $currentDate->copy()->startOfMonth();
            $startDayOfWeek = $firstDayOfMonth->dayOfWeek; // 0 (Sun) - 6 (Sat)
        @endphp

        <!-- Add empty cells for days before the first of the month -->
        @for ($i = 0; $i < $startDayOfWeek; $i++)
            <div class="calendar-cell bg-gray-300 p-4"></div>
        @endfor

        <!-- Generate calendar days -->
        @for ($day = 1; $day <= $currentDate->daysInMonth; $day++)
            @php
                $currentDay = $currentDate->copy()->day($day)->format('Y-m-d');
                $hasRecord = in_array($currentDay, $daysWithRecords);
                $transactionItem = $transactions->firstWhere(function ($item) use ($currentDay) {
                    return \Carbon\Carbon::parse($item->rent_date)->format('Y-m-d') === $currentDay;
                });
                $date = $transactionItem ? \Carbon\Carbon::parse($transactionItem->rent_date)->format('Y-m-d') : null;
                $isSunday = \Carbon\Carbon::parse($currentDay)->dayOfWeek === 0; // 0 for Sunday
            @endphp

            <button 
                @if($hasRecord)
                    hx-get="{{ $date ? route('dateView', ['date' => $date]) : '#' }}"
                    hx-target="#modal-item"
                    hx-swap="innerHTML"
                    hx-trigger="click"
                @endif
                class="relative transition-transform duration-300 ease-in-out transform hover:scale-105 cursor-auto calendar-cell {{ $hasRecord ? 'bg-blue-500 text-white cursor-pointer shadow-md transition-transform duration-300 ease-in-out transform hover:scale-105' : 'bg-gray-300' }} p-4 flex flex-col items-center justify-center font-semibold overflow-hidden group">
                <div class="flex justify-center items-center">
                    <h1 class="font-bold text-6xl {{ $isSunday ? 'text-red-500' : '' }}">{{ $day }}</h1>
                </div>
                @if(!$hasRecord)
                    <div onclick="document.getElementById('transaction-add-{{$day}}').classList.remove('hidden')" title="Click to add a transaction manually" class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-white opacity-0 group-hover:opacity-100 bg-gray-500 transition-opacity duration-300 ease-in-out">
                        <h1 class="flex justify-center items-center text-6xl">+</h1>
                    </div>
                @endif
            </button>
            @include('pages.partials.modals.transaction-add')
        @endfor
    </div>
</div>

<script>
    function showModal(modalId) {
        if (modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
    }

    function hideModal(modalId) {
        if (modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    }

    const sidebar = document.getElementById('sidebar');
    const menuItems = document.getElementById('menu-items');
    const toggleButton = document.getElementById('toggle-button');
    const notificationIcon = document.getElementById('notification-icon');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const userIcon = document.getElementById('user-icon');
    const userDropdown = document.getElementById('user-dropdown');
    const logoLabel = document.getElementById('logoLabel');

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('w-64');
        sidebar.classList.toggle('w-20');
        toggleButton.querySelector('i').classList.toggle('fa-arrow-left');
        toggleButton.querySelector('i').classList.toggle('fa-arrow-right');
        logoLabel.classList.toggle('hidden');

        const isExpanded = sidebar.classList.contains('w-64');
        [...menuItems.children].forEach(item => {
            item.classList.toggle('justify-center', !isExpanded);
            item.classList.toggle('pl-4', isExpanded);
            item.querySelector('span').classList.toggle('hidden', !isExpanded);
        });
    });

    notificationIcon.addEventListener('click', () => {
        notificationDropdown.classList.toggle('hidden');
    });

    userIcon.addEventListener('click', () => {
        userDropdown.classList.toggle('hidden');
    });

    // Auto-submit form on select change
    document.querySelectorAll('#filter-form select').forEach(select => {
        select.addEventListener('change', () => {
            document.getElementById('filter-form').submit();
        });
    });
</script>
@endsection
