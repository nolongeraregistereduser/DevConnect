<!-- resources/views/profile/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile View') }}
        </h2>
    </x-slot>

    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Main Profile Card -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <!-- Profile Header -->
                <div class="h-48 bg-gradient-to-r from-blue-500 to-indigo-600 relative">
                    <!-- Profile Picture -->
                    <div class="absolute -bottom-16 left-8">
                        {{-- {{dd($user)}} --}}
                        @if($user->profile_picture)
                            <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="{{ $user->name }}"
                                 class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-lg">
                                 <h1>test</h1>
                        @else
                            <div class="w-32 h-32 rounded-full border-4 border-white bg-gray-200 flex items-center justify-center shadow-lg">
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Profile Info -->
                <div class="pt-20 px-8 pb-8">
                    <div class="flex flex-wrap items-start justify-between">
                        <div class="w-full md:w-2/3">
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            
                            @if($user->location)
                                <div class="flex items-center text-gray-600 mt-2">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $user->location }}
                                </div>
                            @endif
                            
                            @if($user->bio)
                                <div class="mt-4 text-gray-700 leading-relaxed">
                                    {{ $user->bio }}
                                </div>
                            @endif
                            
                            @if(Auth::id() !== $user->id)
                                <div class="mt-4">
                                    <form action="{{ route('connections.store', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors duration-150 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                            </svg>
                                            {{ $isConnected ? 'Connected' : 'Connect' }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                        
                        <div class="w-full md:w-1/3 mt-6 md:mt-0">
                            <div class="flex flex-wrap justify-end gap-2">
                                @if($user->website)
                                    <a href="{{ $user->website }}" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.083 9h1.946c.089-1.546.383-2.97.837-4.118A6.004 6.004 0 004.083 9zM10 2a8 8 0 100 16 8 8 0 000-16zm0 2c-.076 0-.232.032-.465.262-.238.234-.497.623-.737 1.182-.389.907-.673 2.142-.766 3.556h3.936c-.093-1.414-.377-2.649-.766-3.556-.24-.56-.5-.948-.737-1.182C10.232 4.032 10.076 4 10 4zm3.971 5c-.089-1.546-.383-2.97-.837-4.118A6.004 6.004 0 0115.917 9h-1.946zm-2.003 2H8.032c.093 1.414.377 2.649.766 3.556.24.56.5.948.737 1.182.233.23.389.262.465.262.076 0 .232-.032.465-.262.238-.234.498-.623.737-1.182.389-.907.673-2.142.766-3.556zm1.166 4.118c.454-1.147.748-2.572.837-4.118h1.946a6.004 6.004 0 01-2.783 4.118zm-6.268 0C6.412 13.97 6.118 12.546 6.03 11H4.083a6.004 6.004 0 002.783 4.118z" clip-rule="evenodd"></path>
                                        </svg>
                                    </a>
                                @endif
                                
                                @if($user->github_link)
                                    <a href="{{ $user->github_link }}" target="_blank" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                        <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                        </svg>
                                    </a>
                                @endif
                                
                                <a href="mailto:{{ $user->email }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        
                    </div>
                </div>
            </div>

            
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-8">
                    <!-- Skills Section -->
                    @if($user->skills)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Skills</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->skills as $skill)
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-sm">{{ $skill }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Programming Languages Section -->
                    @if($user->programming_languages)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Programming Languages</h2>
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->programming_languages as $language)
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm">{{ $language }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Projects Section -->
                    @if($user->projects)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Projects</h2>
                            <div class="space-y-6">
                                @foreach($user->projects as $project)
                                    <div class="bg-gray-50 rounded-lg p-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $project['title'] }}</h3>
                                        <p class="mt-2 text-gray-600">{{ $project['description'] }}</p>
                                        @if(isset($project['link']))
                                            <a href="{{ $project['link'] }}" target="_blank" class="mt-3 inline-flex items-center text-sm font-medium text-blue-600 hover:text-blue-800">
                                                View Project
                                                <svg class="ml-1 w-4 h-4" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="space-y-8">
                    <!-- Certifications Section -->
                    @if($user->certifications)
                        <div class="bg-white rounded-lg shadow-md p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Certifications</h2>
                            <div class="space-y-4">
                                @foreach($user->certifications as $certification)
                                    <div class="border-l-4 border-blue-500 pl-4 py-1">
                                        <h3 class="font-medium text-gray-900">{{ $certification['title'] }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">
                                            {{ $certification['organization'] }} • {{ $certification['date'] }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4 pb-2 border-b">Contact Information</h2>
                        <div class="space-y-3">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-gray-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm text-gray-600">Email</p>
                                    <p class="text-gray-900">{{ $user->email }}</p>
                                </div>
                            </div>
                            
                            @if($user->website)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">Website</p>
                                        {{-- <a href="{{route( $user->website )}}" target="_blank" class="text-blue-600 hover:underline">{{ $user->website }}</a> --}}
                                    </div>
                                </div>
                            @endif
                            
                            @if($user->github_link)
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-gray-500 mr-3 mt-1" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm text-gray-600">GitHub</p>
                                        <a href="{{ $user->github_link }}" target="_blank" class="text-blue-600 hover:underline">{{ basename($user->github_link) }}</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>