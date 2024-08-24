
@foreach($contacts as $contact)
                <a href="{{ route('chatSelected', [ 'contact'=> $contact->sender_name ]) }}">
                    <li class="{{ $contact->sender_name == $receiver_name ? 'bg-gray-200' : '' }} hover:bg-gray-300 p-3 rounded-lg mb-2 cursor-pointer duration-300">
                        <div class="flex justify-between mx-2 items-center">
                            <div class="flex items-center space-x-2">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center overflow-hidden">
                                    
                                    <img src="{{ asset('asset/photos/user.png') }}" alt="Profile Icon" class="w-full h-full object-cover">
                                  
                                </div>
                                <div>
                                    <h1 class="font-semibold">{{ $contact->sender_name }}</h1>
                                    <h1 class="{{ $contact->isRead == false ? 'font-bold' : '' }} w-[150px] truncate text-gray-600">{{ $contact->content }}</h1>
                                </div>
                            </div>
                            <div class="flex justify-end">
                              
                                <i class="text-green-500 text-[8px] fa-solid fa-circle"></i>
                               
                            </div>
                        </div>
                    </li>
                </a>
                @endforeach

                @if(count($contacts) == 0)
                <div class="m-2">
                    <h1 class="text-center">No match found.</h1>
                </div>

                @endif

              