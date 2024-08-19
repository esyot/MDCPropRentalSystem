<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MDC - Property Rental System</title>
    <link rel="stylesheet" href="{{ asset('asset/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/fontawesome.min.css') }}">
    <script src="{{ asset('asset/js/tailwind.min.js') }}"></script>
    <script src="{{ asset('asset/js/htmx.min.js') }}"></script>
    <link rel="icon" href="{{asset('asset/photos/logo.png')}}" type="image/png">
    <style>
        .scrollbar-thin::-webkit-scrollbar {
        width: 8px; 
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 9999px; 
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background-color: #f3f4f6; 
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-gray-100 text-gray-800">

    <!-- Sidebar -->
    <div id="sidebar" class="h-full flex flex-col bg-gradient-to-b from-blue-500 to-blue-800 to- text-white shadow-lg transition-all duration-300 ease-in-out w-20">
        <!-- Logo and Label -->
        <div class="flex flex-col items-center mt-6">
            <img class="w-12 h-12" src="{{asset('asset/photos/logo.png')}}" alt="Logo">
            <span id="logoLabel" class="ml-4 text-sm text-center hidden">MDC - Property Rental & <br>Reservation System</span>
        </div>

        <div id="menu-items" class="mt-10 space-y-6">
            <a href="#" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Dashboard">
                <i class="fa-solid fa-gauge fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Dashboard</span>
            </a>
            <a href="#" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Pending requests">
                <i class="fa-solid fa-list fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Pending Requests</span>
            </a>
            <a href="#" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Messages">
                <i class="fa-solid fa-message fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Messages</span>
            </a>
            <a href="#" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Manage Roles">
                <i class="fa-solid fa-users-gear fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Manage Roles</span>
            </a>
            <a href="#" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Manage Users">
                <i class="fas fa-users fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Manage Users</span>
            </a>
        </div>

        <div class="mt-auto mb-6 flex justify-center">
            <button id="toggle-button" onclick="toggleSidebar()" class="p-2 flex items-center justify-center bg-blue-500 hover:bg-blue-700 rounded-full transition duration-200 transition-transform duration-300 ease-in-out transform hover:scale-110">
                <i class="fa-solid fa-arrow-right text-white "></i>
            </button>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Navbar -->
        <div class="flex items-center justify-between bg-white p-4 shadow-md relative">
            <!-- App Naddme -->
            <div class="flex items-center space-x-2">
                <span class="text-lg font-semibold">Dashboard</span>
            </div>

            <!-- Right-side icons -->
            <div class="flex items-center space-x-6 relative">
                <!-- Notification Icon -->
<div class="relative" id="inside-notification">
    <!-- Notification Button -->
    <button id="notification-icon" class="hover:text-gray-300">
        <i class="fa-solid fa-bell fa-lg text-blue-600"></i>
        <span>Notifications</span>
        @if($unreadNotifications > 0)
        <span id="notification-count" class="absolute bottom-1 left-4 flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full -translate-x-1/2 -translate-y-1/2">
            {{ $unreadNotifications }}
        </span>
        @endif
    </button>

    <!-- Notification Dropdown -->
    <div id="notification-dropdown" class="rounded absolute right-0 mt-2 hidden w-[30rem] bg-white p-2 shadow-lg border border-gray-200 z-50">
    <div>
            <h1 class="text-2xl font-bold">Notifications</h1>
    </div> 
    
    <div class="m-2 font-medium">
            <button id="all" onclick="document.getElementById('all').classList.add('bg-blue-300'); document.getElementById('unread').classList.remove('bg-blue-300')"
                hx-get="{{ route('notificationList', ['filter'=>'all'])}}" 
                hx-swap="innerHTML" 
                hx-trigger="click" 
                hx-target="#notification-list"
                class="px-2 rounded-full text-blue-500 bg-blue-300 hover:bg-blue-200">
                All
            </button>


            <button id="unread" onclick="document.getElementById('unread').classList.add('bg-blue-300'); document.getElementById('all').classList.remove('bg-blue-300');"
                hx-get="{{ route('notificationList', ['filter'=>'unread'])}}" 
                hx-swap="innerHTML" 
                hx-trigger="click" 
                hx-target="#notification-list"
                class="px-2 text-blue-500 rounded-full hover:bg-blue-200">
                Unread
            </button>

        </div>
        <div id="notification-list" class="flex flex-col max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-gray-100">
            @include('pages.partials.notification-list')
            <!-- "See More" Button -->
            @if(count($notifications) > 5)
            <button id="see-more-btn" class="w-full p-2 text-blue-600 cursor-pointer hover:bg-blue-100 transition duration-150 ease-in-out">
                See More
            </button>
            @endif
    
    </div>
</div>




                <!-- User Icon -->
                <div id="inside-user" class="relative">
                    <button id="user-icon">
                    <i  class="fa-solid fa-user fa-lg text-blue-600 cursor-pointer"></i>
                    Juan Dela Cruz
                    </button>
                    

                    <!-- User Dropdown -->
                    <div id="user-dropdown" class="absolute right-0 mt-2 hidden min-w-[12rem] p-2 bg-white rounded-lg shadow-lg">
                        <div class="p-2 text-gray-800 cursor-pointer hover:bg-gray-200">
                            <i class="fas fa-user mr-2"></i> Profile
                        </div>
                        <div class="p-2 text-gray-800 cursor-pointer hover:bg-gray-200">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </div>
                        <div class="p-2 text-gray-800 cursor-pointer hover:bg-gray-200">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </div>
                    </div>

                </div>
            </div>
        </div>

       @yield('content')

       <script>
    document.addEventListener('DOMContentLoaded', function() {
        
        const seeMoreBtn = document.getElementById('see-more-btn');
        const notificationList = document.getElementById('notification-list');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const userDropdown = document.getElementById('user-dropdown');
        const insideUser = document.getElementById('inside-user');
        const insideNotification = document.getElementById('inside-notification');

        if (seeMoreBtn) {
            seeMoreBtn.addEventListener('click', function() {
                if (notificationList.classList.contains('max-h-64')) {
                    notificationList.classList.remove('max-h-64');
                    notificationList.classList.add('max-h-[calc(100vh-8rem)]'); // Adjusted max height to fit within viewport
                    seeMoreBtn.textContent = 'See Less';

                    // Adjust dropdown position to fit within the viewport
                    const rect = dropdown.getBoundingClientRect();
                    const viewportHeight = window.innerHeight;

                    if (rect.bottom > viewportHeight) {
                        dropdown.style.top = `-${rect.bottom - viewportHeight}px`;
                    }
                } else {
                    notificationList.classList.remove('max-h-[calc(100vh-8rem)]');
                    notificationList.classList.add('max-h-64');
                    seeMoreBtn.textContent = 'See More';
                }
            });
        }
        
        document.addEventListener('click', function(event) {
            const clickedElement = event.target;
            
            // Hide user dropdown if click is outside of it
            if (!userDropdown.contains(clickedElement) && !insideUser.contains(clickedElement)) {
                userDropdown.classList.add('hidden');
            }

            // Hide notification dropdown if click is outside of it
            if (!notificationDropdown.contains(clickedElement) && !insideNotification.contains(clickedElement)) {
                notificationDropdown.classList.add('hidden');
            }
        });

    });
</script>
