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
        width: 4px; 
        }
        .scrollbar-thin::-webkit-scrollbar-thumb {
            background-color: #4b5563;
            border-radius: 9999px; 
        }
        .scrollbar-thin::-webkit-scrollbar-track {
            background-color: #f3f4f6; 
        }
        
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px; 
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1; 
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 10px; 
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555; 
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
            <a href="{{ route('dashboard') }}" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Dashboard">
                <i class="fa-solid fa-gauge fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Dashboard</span>
            </a>
            <a href="{{ route('transactions')}}" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Pending requests">
                <i class="fa-solid fa-list fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Pending Requests</span>
            </a>
            <a href="{{ route('messages') }}" class="w-full p-3 flex items-center justify-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Messages">
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
                <span class="text-lg font-semibold"> {{ $page_title }}</span>
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
    
    <div class="flex justify-between items-center">
    <div class="font-medium p-2">
            <button id="all" onclick="document.getElementById('all').classList.add('bg-blue-300'); document.getElementById('unread').classList.remove('bg-blue-300')"
                hx-get="{{ route('notificationList', ['filter'=>'all'])}}" 
                hx-swap="innerHTML" 
                hx-trigger="click" 
                 hx-indicator="#loader"
                hx-target="#notification-list"
                class="px-2 rounded-full text-blue-500 bg-blue-300 hover:bg-blue-200">
                All
            </button>


            <button id="unread" onclick="document.getElementById('unread').classList.add('bg-blue-300'); document.getElementById('all').classList.remove('bg-blue-300');"
                hx-get="{{ route('notificationList', ['filter'=>'unread'])}}" 
                hx-swap="innerHTML" 
                hx-trigger="click" 
                hx-indicator="#loader"
                hx-target="#notification-list"
                class="px-2 text-blue-500 rounded-full hover:bg-blue-200">
                Unread
            </button>
        </div>

        <div class="relative inline-block text-left">
        <button id="dropdownButton" class="focus:outline-none">
            <i class="text-blue-500 hover:bg-blue-200 p-2 fas fa-ellipsis rounded-full"></i>
        </button>
        <div id="dropdownMenu" class="dropdown-content absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded shadow-lg">
            <a href="{{ route('readAll') }}" class="block px-4 py-2 text-gray-700 rounded hover:bg-gray-100">
                <i class="fas fa-check-circle mr-2"></i> Mark as all read
            </a>
            <a href="{{ route('deleteAll') }}" class="block px-4 py-2 text-gray-700 rounded hover:bg-gray-100">
                <i class="fas fa-trash mr-2"></i> Delete All
            </a>
        </div>

    </div>
        </div>
       
        <div id="loader" class="rounded  bg-gray-400 bg-opacity-50 absolute inset-0 flex items-center justify-center z-50 hidden">
       
            <img src="{{asset('asset/loader/loading.gif')}}" alt="Loading..." class="w-16 h-16">
        </div>

        <div id="notification-list" class="z-10 flex flex-col max-h-64 overflow-y-auto scrollbar-thin scrollbar-thumb-blue-500 scrollbar-track-gray-100">
        
        @include('pages.partials.notification-list')

       
            <!-- "See More" Button -->
            @if(count($notifications) > 5)
            <button id="see-more-btn" class="w-full p-2 text-blue-600 cursor-pointer hover:bg-blue-100 transition duration-150 ease-in-out">
                See More
            </button>
            @endif
    
    </div>
</div>
 <!-- Messages Icon -->
 @if($page_title != 'Messages')
                <div class="relative" id="inside-notification  items-center">
                    <button id="message-button" class="flex items-center hover:text-gray-300 focus:outline-none">
                        <i class="fa-solid fa-envelope fa-lg text-blue-600"></i>
                        <span class="ml-2">Messages</span>

                        @if($unreadMessages > 0)
                        <span id="notification-count"
                            class="absolute top-0 right-0 flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full transform -translate-x-1/2 -translate-y-1/2">
                            {{ $unreadMessages }}
                        </span>
                        @endif
                    </button>

                    <!-- Messages Dropdown Menu -->
                    <div id="messages-dropdown"
                        class="absolute right-0 hidden mt-2 w-64 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
                        <div class="p-2 max-h-80 overflow-y-auto">
                            <div class="relative m-2">
                                <form hx-get="{{ route('contacts') }}"
                                    hx-trigger="input"
                                    hx-swap="innerHTML"
                                    hx-target="#contact-list"
                                    class="flex justiify-around px-2 items-center bg-gray-100 rounded-full">
                                    <div class="p-2">
                                        <i class="fas fa-search text-gray-500"></i>
                                    </div>
                                    <input type="text" name="searchValue" placeholder="Search contact"
                                        class="placeholder-center mr-8 focus:outline-none bg-transparent">
                                </form>
                            </div>
                            <ul id="contact-list" class="list-none">
                                @include('pages.partials.contact-list')
                            </ul>
                        </div>
                    </div>
                </div>
                @endif




                <!-- User Icon -->
                <div id="inside-user" class="relative">
                    <button id="user-icon">
                    <i  class="fa-solid fa-user fa-lg text-blue-600 cursor-pointer"></i>
                    Juan Dela Cruz
                    </button>
                    

                    <!-- User Dropdown -->
                    <div id="user-dropdown" class="absolute right-0 mt-2 hidden min-w-[12rem] p-2 bg-white rounded-lg shadow-lg z-50">
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
       
        document.body.addEventListener('htmx:beforeRequest', function() {
            document.getElementById('loader').classList.remove('hidden');
        });

        document.body.addEventListener('htmx:afterRequest', function() {
            document.getElementById('loader').classList.add('hidden');
        });

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
                    notificationList.classList.add('max-h-[calc(100vh-8rem)]'); 
                    seeMoreBtn.textContent = 'See Less';

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

            const button = document.getElementById('dropdownButton');
            const menu = document.getElementById('dropdownMenu');

            button.addEventListener('click', function () {
                menu.classList.toggle('hidden');
            });

             
            document.addEventListener('click', function (event) {
                if (!button.contains(event.target) && !menu.contains(event.target)) {
                    menu.classList.add('hidden');
                }
            });

    });
</script>
