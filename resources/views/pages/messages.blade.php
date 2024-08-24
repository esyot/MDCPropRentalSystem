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


        /* Navbar at the top */
        .navbar {
            position: fixed;
            top: 0;
            left: 5rem; /* Starts after the sidebar */
            right: 0;
            z-index: 10;
            background-color: #fff; /* Tailwind's gray-800 */
            color: black;
            padding: 1rem;
            transition: left 0.3s ease;
        }

        .navbar.expanded {
            left: 18rem; /* Adjust according to the expanded sidebar width */
        }

        /* Sidebar on the left */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 5rem;
            overflow-y: auto;
            z-index: 5;
            transition: width 0.3s ease;
        }

        .sidebar.expanded {
            width: 18rem; /* Expanded width */
        }

        /* Main content next to the sidebar */
        .main-content {
            margin-top: 4rem; /* Aligns with the navbar */
            margin-left: 5rem; /* Aligns with the sidebar width */
            height: calc(100vh - 4rem); /* Adjusted for full height minus navbar */
            display: flex;
            flex: 1;
            overflow-y: auto;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 18rem; /* Margin when sidebar is expanded */
        }

        /* Box styles */
        .box-c {
            overflow-y: auto;
            flex: 1;
            display: flex;
            flex-direction: column;
            
        }

        .box-a {
            height: 100%;
            margin: 3rem;
            width: 100%;
        }
         /* Custom CSS to center the placeholder */
         .placeholder-center::placeholder {
            text-align: center; /* Center the placeholder text */
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div id="sidebar" class="bg-gradient-to-b from-blue-500 to-blue-800 sidebar p-4">
       <!-- Logo and Label -->
       
        <div class="flex justify-between items-center flex-col">

       <div class="flex flex-col items-center">
            <img class="w-12 h-12" src="{{asset('asset/photos/logo.png')}}" alt="Logo">
            <span id="logoLabel" class="text-white ml-4 text-sm text-center hidden">MDC - Property Rental & <br>Reservation System</span>
        </div>

        <div id="menu-items" class="mt-10 space-y-6 flex flex-col transition-transform duration-600 ease">
            <a href="{{ route('dashboard') }}" class="w-full p-3 flex items-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Dashboard">
                <i class="fa-solid fa-gauge fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Dashboard</span>
            </a>
            <a href="{{ route('transactions')}}" class="w-full p-3 flex items-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Pending requests">
                <i class="fa-solid fa-list fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Pending Requests</span>
            </a>
           
            <a href="#" class="w-full p-3 flex items-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Manage Roles">
                <i class="fa-solid fa-users-gear fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Manage Roles</span>
            </a>
            <a href="#" class="w-full p-3 flex items-center text-white hover:text-blue-300 transition duration-200 rounded-lg" title="Manage Users">
                <i class="fas fa-users fa-lg transition-transform duration-300 ease-in-out transform hover:scale-110"></i>
                <span class="ml-4 text-sm hidden">Manage Users</span>
            </a>
        </div>

        <div class="flex justify-center items-center mt-16">
            <button id="sidebarToggle" class=" p-2 flex items-center justify-center bg-blue-500 hover:bg-blue-700 rounded-full transition duration-200 transition-transform duration-300 ease-in-out transform hover:scale-110">
                <i class="fa-solid fa-arrow-right text-white "></i>
            </button>
        </div>


        
        </div>
    </div>
    </div>


    <div id="navbar" class="navbar shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Page Title -->
        <div class="text-2xl font-bold text-gray-800">
            {{$page_title}}
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
           {{ $unreadNotifications  }}
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

@if($page_title != 'Messages')
<div class="relative" id="inside-notification">
    <!-- Message Button -->
    <button id="message-button" class="flex items-center hover:text-gray-300 focus:outline-none">
        <i class="fa-solid fa-envelope fa-lg text-blue-600"></i>
        <span class="ml-2">Messages</span>
       
        @if($unreadMessages > 0)
        <span id="notification-count" class="absolute top-0 right-0 flex items-center justify-center w-4 h-4 text-xs font-bold text-white bg-red-600 rounded-full transform -translate-x-1/2 -translate-y-1/2">
           {{ $unreadMessages }}
        </span>
        @endif
    </button>

    <!-- Dropdown Menu -->
    <div id="messages-dropdown" class="absolute right-0 hidden mt-2 w-64 bg-white border border-gray-300 rounded-lg shadow-lg z-10">
        <div class="p-2 max-h-80 overflow-y-auto">
        <div class="relative m-2">
                <form hx-get="{{ route('contacts') }}"
                hx-trigger="input"
                hx-swap="innerHTML"
                hx-target="#contact-list" class="flex justiify-around px-2 items-center bg-gray-100 rounded-full">

                <div class="p-2">
                    <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" name="searchValue" placeholder="Search contact" class="placeholder-center mr-8 focus:outline-none bg-transparent">
                    
                   
                   
                </form>  
                    
            </div>
            <ul id="contact-list" class="list-none">
            
               @include('pages.partials.contact-list')

        </ul>   
        </div>
    </div>
</div>
<script>
     const messageButton = document.getElementById('message-button');
    const dropdownMenu = document.getElementById('messages-dropdown');

    messageButton.addEventListener('click', function(event) {
        event.preventDefault();
        dropdownMenu.classList.toggle('hidden');
    });

    // Close the dropdown if the user clicks outside of it
    document.addEventListener('click', function(event) {
        if (!messageButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>

@endif



                <!-- User Icon -->
                <div id="inside-user" class="relative">
                    <button id="user-icon">
                    <i  class="fa-solid fa-user fa-lg text-blue-600 cursor-pointer"></i>
                    {{ $current_user_name }}
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
    </div>
</div>


    <!-- Main Content -->
    <div id="main-content" class="main-content flex bg-gray-100">
        <!-- Box A -->
        <div class="w-80 m-2 flex items-center flex-col ">

        <div class="text-2xl font-bold m-2">
            Chats
        </div>
        <div>
            <div class="relative my-2 mx-1 mb-4">
                <form hx-get="{{ route('contacts') }}"
                hx-trigger="input"
                hx-swap="innerHTML"
                hx-target="#contact-list" class="flex justiify-around px-2 items-center bg-white rounded-full">

                <div class="p-2">
                    <i class="fas fa-search text-gray-500"></i>
                    </div>
                    <input type="text" name="searchValue" placeholder="Search contact" class="placeholder-center mr-8 focus:outline-none bg-transparent">
                    
                   
                   
                </form>  
                    
            </div>

        </div>
        <ul id="contact-list" class="list-none">
            
               @include('pages.partials.contact-list')

        </ul>         
         
        </div>
        <!-- Box C -->
        <div class="w-full flex flex-col">

        <div class="bg-blue-500 shadow-md p-2">
            <div class="items-center flex ">
            <img class="w-12 h-12 p-2 drop-shadow-md" src="{{ asset('asset/photos/user.png') }}" alt="">
            <div class="text-xl text-white font-semibold">
                {{ $receiver_name }}
            </div>

            </div>

            <div class="relative flex w-full h-full"> <!-- Adjust the parent container to have width and height -->
            <div class="absolute inset-0 top-[17rem] flex items-center justify-center"> <!-- Center the child in the parent -->
                 <img class="bg-blue-500 rounded-full p-2 flex w-[300px] opacity-10 drop-shadow-2xl" src="{{asset('asset/photos/logo.png')}}" alt="">
            </div>
            </div>

        
        </div>
        
       

        <div id="messages-container" class="box-c bg-blue-300 scrollbar-thin h-64">
    @if(count($allMessages) == 0)
        <div class="flex flex-wrap w-full h-full items-center justify-center">
            
        <p class="p-4 text-center">No chat selected. Please choose a contact.</p>

        </div>
    @endif

    <style>
        
    </style>
    


   
        
            <!-- Messages Bubble Section -->
            <div class="flex flex-col bg-blue-200">
            
                @foreach($allMessages as $message)
                @if(count($allMessages) < 0)
                    <div >
                         <p class="p-4 bg-red-500">  no chat selected!</p> 
                    </div>
                    @endif
                @include('pages.partials.modals.image-preview')


                <div class="relative space-x-2 flex {{ $message->sender_name == $current_user_name ? 'justify-end' : 'justify-start' }} p-3 rounded-lg group">
                  
                @if($message->sender_name != $current_user_name)
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('asset/photos/user.png')}}" alt="Profile Icon" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="">
                        @if($message->sender_name == $current_user_name && $message->replied_message_type != null) 
                        
                      
                        <div class="flex flex-col">

                        
                        <small class="flex items-center space-x-1 {{ $message->sender_name == $current_user_name ? 'justify-end' : 'justify-start' }}">
                            <i class="hover:text-gray-500 fa-solid fa-share" style="transform: scaleX(-1);"></i>
                                @if($message->replied_message_name == $current_user_name)
                                    <h1>You replied to yourself</h1>
                                @endif
                                @if($message->replied_message_name != $current_user_name)
                                    <h1>You replied to {{ explode(' ',$message->replied_message_name)[0]}}</h1>
                                @endif
                           
                        </small>
                       
                            <div class="relative w-[400px]">
                        
                                    <div class="{{ $message->sender_name == $current_user_name ? 'float-end' : 'float-start' }} text-justify bg-opacity-30 text-blue-500 inline-block max-w-full opacity-50 rounded-2xl shadow-sm relative">
                                    
                             @if($message->replied_message_type == 'text')
                            <div class="bg-gray-200 p-2 text-gray-800 rounded-xl">
                                <h1>{{ $message->replied_message }}</h1>
                            </div>
                             

                              @endif

                              @if($message->replied_message == 'like')
                              <div class="{{ $message->sender_name == $current_user_name ? 'float-end' : 'float-start' }} text-justify bg-opacity-30 text-blue-500 inline-block max-w-full opacity-50 rounded-2xl relative">
                                    

                                <i class="text-[120px] fa-solid fa-thumbs-up"></i>
                                </div>

                              @endif  
                              @if($message->replied_message_type == 'image')
                              <img width="200" src="{{ asset('storage/images/' . $message->replied_message) }}" alt="">

                              @endif    

                                        </div>
                               

    
                            </div>

                            </div>
                           
                    
                        @endif


                        <!-- for contacts -->

                        @if($message->sender_name != $current_user_name && $message->replied_message != null) 
                        
                      
                        <div class="flex flex-col">

                        
                        <small class="flex items-center space-x-1 {{ $message->sender_name == $current_user_name ? 'justify-end' : 'justify-start' }}">
                            <i class="hover:text-gray-500 fa-solid fa-share" style="transform: scaleX(-1);"></i>
                                @if($message->replied_message_name != $current_user_name)
                                    <h1>{{explode(' ', $message->replied_message_name)[0] }} replied to itself</h1>
                                @endif
                                @if($message->replied_message_name == $current_user_name)
                                    <h1>{{ explode(' ', $receiver_name)[0]}} replied to you</h1>
                                @endif  
                           
                        </small>
                       
                            <div class="relative w-[400px]">
                               

                                @if($message->replied_message == 'like')
                                    <div class="{{ $message->sender_name == $current_user_name ? 'float-end' : 'float-start' }} text-blue-500 text-justify bg-opacity-30 inline-block max-w-full shadow-sm relative">
                                    

                                <i class="text-[120px] fa-solid fa-thumbs-up"></i>


                                @endif

                                @if($message->replied_message != 'like')
                                <div class="{{ $message->sender_name == $current_user_name ? 'float-end' : 'float-start' }} text-justify bg-opacity-30 bg-gray-200 inline-block max-w-full p-4 rounded-2xl shadow-sm relative">
                                    

                                <h1 class="p-1 text-gray-500 break-words">{{ $message->replied_message }}</h1>

                                @endif
                                


                                </div>
                            </div>

                            </div>
                           
                    
                        @endif
                        <div onmouseover="document.getElementById('icons-{{$message->id}}').classList.remove('hidden')"
                             onmouseout="document.getElementById('icons-{{$message->id}}').classList.add('hidden')"
                             class="w-[400px] flex {{ $message->sender_name == $current_user_name ? 'justify-end' : '' }} items-center space-x-1">
                           
                           <!-- icons right -->

                             @if($message->sender_name == $current_user_name)
                                <div id="icons-{{$message->id}}" class="items-center hidden">
                                    <form class="flex" action="{{ route('messageReacted', ['id'=>$message->id]) }}">
                                        <button type="submit" title="React"
                                        class="px-1 py-1.2 rounded-full hover:bg-blue-500 ">
                                            <i class="hover:text-blue-100 fa-regular fa-face-smile"></i>
                                        </button>

                                        <button title="Reply"  class="px-1 py-1.2 rounded-full hover:bg-blue-500"
                                        onclick="handleButtonClick('{{ $message->id }}', '{{ $message->sender_name }}', '{{ $message->type }}', '{{ $sender_name }}', '{{ $receiver_name }}')" type="button">
                                            <i class="hover:text-blue-100 fa-solid fa-share" style="transform: scaleX(-1);"></i>    
                                        </button>
                                    </form>
                                </div>
                            @endif


                           
                                
                                <div class="{{ $message->sender_name == $current_user_name ? 'text-blue-500' : 'text-blue-500' }} text-justify inline-block max-w-full rounded-2xl drop-shadow-sm relative">
                                
                                @if($message->type == 'text')

                                
                                <div class="{{ $message->sender_name == $current_user_name ? 'bg-blue-500 text-white' : 'bg-white text-black' }} p-4  rounded-xl">
                                    <h1 class="break-words">{{ $message->content }}</h1>
                                </div>
                                @elseif($message->type == 'sticker')

                                <div class="{{ $message->sender_name == $current_user_name ? 'float-end' : 'float-start' }} text-justify bg-opacity-30 text-blue-500 inline-block max-w-full rounded-2xl relative">
                                    

                                <i class="text-[120px] fa-solid fa-thumbs-up"></i>
                                </div>

                                @elseif($message->type == 'image')
                                <div class="flex {{ $message->receiver_name == $current_user_name ? 'items-start' : 'items-end' }} flex-col">

                               
                                    <div onclick="document.getElementById('image-preview-{{ $message->id }}').classList.remove('hidden')">
                                        <img class="rounded-xl shadow-md" width="300" src="{{ asset('storage/images/'.$message->img) }}" alt="">
                                    
                                    </div>
                                    @if($message->content != null)
                                    <div class="{{ $message->sender_name == $current_user_name ? 'bg-blue-500 text-white' : 'bg-white text-black' }} p-4  rounded-xl">
                                        <h1 class="break-words">{{ $message->content }}</h1>
                                    </div>
                                    @endif

                                </div>

                                @endif                         


                                @if($message->isReacted == true)
                                    <div class="absolute bottom-[-14px] right-0 mb-1 mr-1 rounded-full w-5 h-5.8 {{ $message->sender_name == $current_user_name ? 'bg-blue-500' : 'bg-white' }} flex items-center justify-center">
                                        <i class="text-sm fa-solid fa-heart text-red-500"></i>
                                    </div>
                                @endif
                            </div>


                            <!-- icons left -->

                            @if($message->sender_name != $current_user_name)
                             <div id="icons-{{$message->id}}" class="items-center hidden">
                                    <form class="flex" action="{{ route('messageReacted', ['id'=>$message->id]) }}">
                                        <button type="submit" title="React"
                                        class="px-1 py-1.2 rounded-full hover:bg-blue-500 ">
                                            <i class="hover:text-blue-100 fa-regular fa-face-smile"></i>
                                        </button>

                                        <button title="Reply"  class="px-1 py-1.2 rounded-full hover:bg-blue-500"
                                        onclick="handleButtonClick('{{ $message->id }}', '{{ $message->sender_name }}', '{{ $message->type }}', '{{ $sender_name }}', '{{ $receiver_name }}')" type="button">
                                            <i class="hover:text-blue-100 fa-solid fa-share" style="transform: scaleX(-1);"></i>    
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        <div class="flex {{ $message->sender_name == $current_user_name ? 'justify-end mr-4' : 'justify-start ml-4' }} mb-2">
                            <small class="text-gray-500">{{ $message->created_at->format('g:i A') }}</small>
                        </div>
                    </div>
                </div>
               
                @endforeach
            </div>
            </div>
            
           

            <div class="bg-blue-500">
            @foreach($allMessages as $message)
                <div id="message-to-reply-{{$message->id}}" class="p-2 bg-white shadow-md hidden">
                    <div class="flex justify-between">
                       

                        @if($message->sender_name == $current_user_name)
                        <h1 class="font-semibold">Replying to yourself</h1>
                        @else
                        <h1 class="font-semibold">Replying to {{$message->sender_name}}</h1>
                        @endif
                        </h1>
                        <button class="text-2xl hover:text-gray-400" 
                            onclick="messageReplyViewClose('{{ $message->id}}')">
                            &times;
                        </button>
                    </div>

                    @if($message->type == 'sticker')
                    <p>
                        sticker
                    </p>
                    @elseif($message->type == 'image')
                    <p>image</p>

                    @else
                    <p>{{ $message->content }}</p>
                    @endif
                </div>
                
            @endforeach
          
           
            <div class="flex space-x-2 p-4 bg-blue-400">
                 
            <form id="myForm" action="{{ route('messageSend') }}" method="POST" class=" flex items-end w-full space-x-4">

                    
                     <input type="file" id="fileInput" class="hidden" accept="image/*" onchange="previewImage(event)">
                    <button type="button" class="transition-transform duration-300 ease-in-out transform hover:scale-110 drop-shadow text-xl px-2 py-2 hover:text-white text-gray-100" onclick="document.getElementById('fileInput').click();">
                        <i class="fa-solid fa-image"></i>
                    </button>



            
                <input type="hidden" name="replied_message_id" id="replied-message-id">
                <input type="hidden" name="replied_message_name" id="replied-message-name">
                <input type="hidden" name="replied_message_type" id="replied-message-type">
                <input type="hidden" value="{{$sender_name}}" name="sender_name" id="sender_name">
                <input type="hidden" value="{{$receiver_name}}" name="receiver_name" id="receiver_name"> 
                <input type="hidden" id="image-data" name="image-data" />

                <div class="relative w-full">
            <div class="flex items-end space-x-2 rounded-lg">
            
                <div class="flex flex-col flex-1 bg-white rounded-lg">
                <div class="flex flex-wrap items-start">
                    <div  class="flex flex-wrap">
                   
                        <div id="image-container" class="flex justify-between">
                            
                        
                        </div>
                    </div>
                    <div id="img-preview-x" class="absolute left-[9.5rem] top-1 text-black font-semibold hover:text-gray-300 hidden">
                     <div class="flex items-center justify-center hover:bg-gray-500 drop-shadow w-6 bg-gray-400 rounded-full">
                        <button onclick="imagePreviewClose()" title="Close"
                            type="button" class="drop-shadow text-white">&times;
                        </button>

                    </div>
                     </div>
                    
                    </div>

                    <div class="flex flex-col p-2 bg-white rounded-lg">

                    <input autocomplete="off" type="text" id="content" name="content" 
                        class="w-full px-2 bg-white rounded-full focus:outline-none" placeholder="Aa">
   
                    </div>
                    
                </div>
                <div class="px-2">

                <button type="submit" id="sendButton" class="transition-transform duration-300 ease-in-out transform hover:scale-110 drop-shadow flex items-center text-xl text-2xl px-2 py-2 hover:text-white text-blue-100 mb-0.5">
                    <i id="sendIcon" class="fa-solid fa-thumbs-up"></i>
                </button>

                </div>
                
            </div>
        </div>
            </div>
                
                
            </form>
        
        </div>
            </div>
        </div>
    </div>
  
    <script>
          
        function imagePreviewClose(){

            document.getElementById('image-container').innerHTML = ''; 
            document.getElementById('img-preview-x').classList.add('hidden');
            document.getElementById('sendIcon').classList.remove('fa-paper-plane');
            document.getElementById('sendIcon').classList.add('fa-thumbs-up');
            document.getElementById('content').focus();

          }

        function updateIcon() {
            const contentInput = document.getElementById('content');
            const sendIcon = document.getElementById('sendIcon');
       
           
            
            if (contentInput.value.trim() === '') {
                // Input is empty, show thumbs up icon
                sendIcon.classList.remove('fa-paper-plane');
                sendIcon.classList.add('fa-thumbs-up');
            } else {
                // Input has value, show paper plane icon
                sendIcon.classList.remove('fa-thumbs-up');
                sendIcon.classList.add('fa-paper-plane');
            }
        }

        // Attach the updateIcon function to the input's input event
        document.getElementById('content').addEventListener('input', updateIcon);

        // Initial check in case the input is not empty on load
        updateIcon();




    function messageReplyViewClose(id){
   

            const messageView = `message-to-reply-${id}`;

            document.getElementById('replied-message-id').value = '';
            document.getElementById('replied-message-name').value = '';
            document.getElementById('replied-message-type').value = '';
            document.getElementById(messageView).classList.add('hidden');

            //changes icon
            
            

            document.getElementById('content').focus();
            
            document.getElementById('sendIcon').classList.remove('fa-paper-plane');
            document.getElementById('sendIcon').classList.add('fa-thumbs-up');
            }



    function updateImageContainerMargin() {
        var imageContainer = document.getElementById('image-container');
        if (imageContainer.innerHTML.trim() !== '') {
            imageContainer.classList.add('m-0'); 
            imageContainer.classList.remove('m-2'); 
        } else{
        

        }
    }

    updateImageContainerMargin();

        function previewImage(event) {
            const file = event.target.files[0];
            
            // Check if file is selected and is an image
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('w-40', 'image-preview', 'rounded-lg', 'shadow', 'm-2');
                    document.getElementById('image-container').innerHTML = ''; 
                    document.getElementById('image-container').appendChild(img);

                    // Set the base64 data URL to the hidden input
                    document.getElementById('image-data').value = e.target.result;

                    document.getElementById('img-preview-x').classList.remove('hidden');

                    document.getElementById('sendIcon').classList.add('fa-paper-plane');
                    document.getElementById('sendIcon').classList.remove('fa-thumbs-up');
                   
                    
                };
                
                reader.readAsDataURL(file);
            } else {
                alert('Please select an image file.');
            }
        }

        // Function to generate a unique identifier
        function generateUniqueId() {
            return 'xxxxxx'.replace(/[x]/g, function() {
                var r = Math.random() * 16 | 0, v = r.toString(16);
                return v;
            });
        }

        // Handle paste event for image files
        document.getElementById('content').addEventListener('paste', function(event) {
            event.preventDefault();
            
            document.getElementById('content').focus();

            if (event.clipboardData && event.clipboardData.items) {
                const items = event.clipboardData.items;

                for (const item of items) {
                    if (item.type.startsWith('image/')) {
                        const file = item.getAsFile();

                        if (file) {
                            // Generate a unique identifier
                            const uniqueId = generateUniqueId();

                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement('img');
                                img.src = e.target.result;
                                img.classList.add('w-40', 'image-preview', 'rounded-lg', 'shadow', 'm-2');
                                document.getElementById('image-container').innerHTML = ''; 
                                document.getElementById('image-container').appendChild(img);

                                // Set the base64 data URL to the hidden input
                                document.getElementById('image-data').value = e.target.result;

                                document.getElementById('img-preview-x').classList.remove('hidden');
                                sendIcon.classList.remove('fa-thumbs-up');
                                sendIcon.classList.add('fa-paper-plane');
                                
                            };
                            reader.readAsDataURL(file);
                        }
                    }
                }
            }
        });
    
    
        

function scrollToBottom() {
        const messagesContainer = document.getElementById('messages-container');
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    // Scroll to the bottom when the page loads
    window.onload = function() {
        scrollToBottom();
        document.getElementById('content').focus();
    }




        // Global variable to track the currently open element
let currentlyVisibleElementId = null;

function handleButtonClick(currentMessageId, replied_message_name, replied_message_type, sender_name, receiver_name) {
    
   

    const newElementId = `message-to-reply-${currentMessageId}`;
    
    // Hide the currently visible element if it's different from the new one
    if (currentlyVisibleElementId && currentlyVisibleElementId !== newElementId) {
        const currentlyVisibleElement = document.getElementById(currentlyVisibleElementId);
        if (currentlyVisibleElement) {
            currentlyVisibleElement.classList.add('hidden');
        }
    }
    
    // Show the new element
    const newElement = document.getElementById(newElementId);
    if (newElement) {
        newElement.classList.remove('hidden');
        document.getElementById('content').focus()
    }
    
    // Update the currently visible element ID
    currentlyVisibleElementId = newElementId;

    // Optionally, update form fields
    document.getElementById('replied-message-id').value = currentMessageId;
    document.getElementById('replied-message-name').value = replied_message_name;
    document.getElementById('replied-message-type').value = replied_message_type;
    document.getElementById('sender-name').value = sender_name;
    document.getElementById('receiver-name').value = receiver_name;
    document.getElementById('content').focus();
}

    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('main-content');
    const navbar = document.getElementById('navbar');
    const toggleButton = document.getElementById('sidebarToggle');
    const menuItems = document.getElementById('menu-items');
    const logoLabel = document.getElementById('logoLabel');

    toggleButton.addEventListener('click', () => {
        const isExpanded = sidebar.classList.contains('expanded');

        // Toggle sidebar and related elements
        sidebar.classList.toggle('expanded', !isExpanded);
        mainContent.classList.toggle('expanded', !isExpanded);
        navbar.classList.toggle('expanded', !isExpanded);

        // Toggle icon classes
        const icon = toggleButton.querySelector('i');
        
        if (icon) {
            icon.classList.remove(isExpanded ? 'fa-arrow-left' : 'fa-arrow-right');
            icon.classList.add(isExpanded ? 'fa-arrow-right' : 'fa-arrow-left');
        }

        // Toggle menu item spans and logo label visibility
        [...menuItems.children].forEach(item => {
            const span = item.querySelector('span');
            if (span) {
                span.classList.toggle('hidden', isExpanded);
            }
        });
        if (logoLabel) {
            logoLabel.classList.toggle('hidden', isExpanded);
        }
    });
   
     document.body.addEventListener('htmx:beforeRequest', function() {
            document.getElementById('loader').classList.remove('hidden');
        });

        document.body.addEventListener('htmx:afterRequest', function() {
            document.getElementById('loader').classList.add('hidden');
        });

    const notificationIcon = document.getElementById('notification-icon');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const userIcon = document.getElementById('user-icon');
    const userDropdown = document.getElementById('user-dropdown');

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

</body>
</html>
