<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DevConnect - Social Network for Developers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-50">
    <!-- Navigation -->


    <nav class="fixed top-0 w-full bg-gray-900 text-white z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="text-2xl font-bold text-blue-400">&lt;DevConnect/&gt;</div>
                    <div class="relative">
                        <input type="text" 
                               placeholder="Search developers, posts, or #tags" 
                               class="bg-gray-800 pl-10 pr-4 py-2 rounded-lg w-96 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-gray-700 transition-all duration-200"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="#" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                    </a>
                    <a href="#" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                        <span class="bg-blue-500 rounded-full w-2 h-2"></span>
                    </a>
                    <a href="#" class="flex items-center space-x-1 hover:text-blue-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="bg-red-500 rounded-full w-2 h-2"></span>
                    </a>
                    <div class="h-8 w-8 rounded-full overflow-hidden">
                        <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="Profile" class="w-full h-full object-cover"/>
                    </div>
                </div>
            </div>
            
        </div>
    </nav>

    <!-- Add this after your navigation section -->
    <div class="mb-6 flex justify-between items-center">
        <h2 class="text-2xl font-semibold">Feed</h2>
        <a href="{{ route('posts.create') }}" 
           class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Post
        </a>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto pt-20 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Profile Card -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-600 to-blue-400"></div>
                        <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="Profile" 
                             class="absolute -bottom-6 left-4 w-20 h-20 rounded-full border-4 border-white shadow-md"/>
                    </div>
                    <div class="pt-14 p-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold">{{$user->name}}</h2>

                            <span>
                            <a href="https://github.com" target="_blank" class="text-gray-600 hover:text-black">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/>
                                </svg>
                            </a>
                        </div>
                        <p> 📍 {{$user->location}}</p>

                        <p class="text-gray-500 text-sm mt-2">{{$user->bio}}</p>
<br> 
                        @foreach($user->skills as $skill)     

                                <span class="px-2 py-1 bg-blue-100 text-red-800 rounded-full text-xs ">{{$skill}}</span>
                        @endforeach

                        <br>

                        @foreach($user->programming_languages as $programming_language)     

                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">{{$programming_language}}</span>
                         @endforeach

                        <div class="mt-4 pt-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Connections</span>
                                <span class="text-blue-600 font-medium">{{ $user->connections_count }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span class="text-gray-500">Posts</span>
                                <span class="text-blue-600 font-medium">{{ $user->posts_count }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Popular Tags -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <h3 class="font-semibold mb-4">Trending Tags</h3>
                    <div class="space-y-2">
                        @foreach($trendingTags as $tag)
                        <a href="#" class="flex items-center justify-between hover:bg-gray-50 p-2 rounded">
                            <span class="text-gray-600">#{{ $tag->name }}</span>
                            <span class="text-gray-400 text-sm">{{ $tag->posts_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Main Feed -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Creation -->
                <div class="bg-white rounded-xl shadow-sm p-4">
                    <div class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $user->profile_picture)}}" alt="User" class="w-12 h-12 rounded-full"/>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-500 text-left rounded-lg px-4 py-3 flex-grow transition-colors duration-200">
                            Share your knowledge or ask a question...
                        </button>
                    </div>
                    <div class="flex justify-between mt-4 pt-4 border-t">
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                            <span>Code</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Image</span>
                        </button>
                        <button class="flex items-center space-x-2 text-gray-500 hover:bg-gray-100 px-4 py-2 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                            </svg>
                            <span>Link</span>
                        </button>
                    </div>
                </div>

                <!-- Posts -->
                @foreach($posts as $post)
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('profile.view', $post->user->id) }}" class="hover:opacity-80">
                                    <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                                         alt="{{ $post->user->name }}" 
                                         class="w-12 h-12 rounded-full"/>
                                </a>
                                <div>
                                    <a href="{{ route('profile.view', $post->user->id) }}" class="hover:text-blue-500">
                                        <h3 class="font-semibold">{{ $post->user->name }}</h3>
                                    </a>
                                    <p class="text-gray-500 text-sm">{{ "📍". $post->user->location  }}</p>
                                    <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <button class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                </svg>
                            </button>
                        </div>
                        
                        <div class="mt-4">
                            <p class="text-gray-700">{{ $post->content }}</p>
                            
                            @if($post->code_snippet)
                            <div class="mt-4 bg-gray-900 rounded-lg p-4 font-mono text-sm text-gray-200">
                                <pre><code>{{ $post->code_snippet }}</code></pre>
                            </div>
                            @endif

                            <div class="mt-4 border-t pt-4">
    <!-- Post Stats Section -->
    <div class="flex items-center space-x-4" id="postStats-{{ $post->id }}">
        <!-- Like Button -->
        <form action="{{ route($post->isLikedBy(auth()->user()) ? 'posts.unlike' : 'posts.like', $post) }}" 
              method="POST" 
              class="like-form">
            @csrf
            @if($post->isLikedBy(auth()->user()))
                @method('DELETE')
            @endif
            <button type="submit" class="flex items-center space-x-2 text-gray-500 hover:text-blue-500 group">
                <svg class="w-5 h-5 {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : 'text-gray-500 group-hover:text-blue-500' }}" 
                     fill="{{ $post->isLikedBy(auth()->user()) ? 'currentColor' : 'none' }}" 
                     stroke="currentColor" 
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                </svg>
                <span class="likes-count {{ $post->isLikedBy(auth()->user()) ? 'text-blue-500' : '' }}">
                    {{ $post->likes_count }}
                </span>
            </button>
        </form>

        <!-- Comment Button -->
        <button onclick="toggleComments('comments-{{ $post->id }}')" 
                class="flex items-center space-x-2 text-gray-500 hover:text-blue-500">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <span>{{ $post->comments_count }}</span>
        </button>
    </div>

    <!-- Comments Section -->
    <div id="comments-{{ $post->id }}" class="hidden mt-4">
    <!-- Add Comment Form -->
    <form class="mb-4 comment-form" data-post-id="{{ $post->id }}">
        @csrf
        <div class="flex items-start space-x-3">
            <img src="{{ auth()->user()->profile_picture ? asset('storage/' . auth()->user()->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                 alt="{{ auth()->user()->name }}" 
                 class="w-8 h-8 rounded-full"/>
            <div class="flex-1">
                <textarea 
                    name="content"
                    placeholder="Write a comment..." 
                    class="w-full px-3 py-2 text-sm border rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                    rows="2"
                ></textarea>
                <div class="mt-2 flex justify-end">
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </form>

    <!-- Comments List -->
    <div class="space-y-4" id="commentsList-{{ $post->id }}">
        @foreach($post->comments as $comment)
            <div class="flex space-x-3">
                <a href="{{ route('profile.view', $comment->user->id) }}" class="hover:opacity-80">
                    <img src="{{ $comment->user->profile_picture ? asset('storage/' . $comment->user->profile_picture) : 'https://avatar.iran.liara.run/public/boy' }}" 
                         alt="{{ $comment->user->name }}" 
                         class="w-8 h-8 rounded-full"/>
                </a>
                <div class="flex-1">
                    <div class="bg-gray-50 rounded-lg px-4 py-2">
                        <a href="{{ route('profile.view', $comment->user->id) }}" class="hover:text-blue-500">
                            <div class="font-medium text-sm">{{ $comment->user->name }}</div>
                        </a>
                        <p class="text-sm text-gray-700">{{ $comment->content }}</p>
                    </div>
                    <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                        <button class="hover:text-blue-500">Reply</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
</div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Add pagination links -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            
                <!-- Right Sidebar -->
                <div class="space-y-6">
                    <!-- Job Recommendations -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Job Recommendations</h3>
                        <div class="space-y-4">
                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                    <div>
                                        <h4 class="font-medium">Senior Full Stack Developer</h4>
                                        <p class="text-gray-500 text-sm">TechStart Inc.</p>
                                        <p class="text-gray-500 text-sm">Remote • Full-time</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">React</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Node.js</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="p-3 hover:bg-gray-50 rounded-lg transition-colors duration-200">
                                <div class="flex items-start space-x-3">
                                    <img src="/api/placeholder/40/40" alt="Company" class="w-10 h-10 rounded"/>
                                    <div>
                                        <h4 class="font-medium">DevOps Engineer</h4>
                                        <p class="text-gray-500 text-sm">CloudScale Solutions</p>
                                        <p class="text-gray-500 text-sm">San Francisco • Hybrid</p>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">AWS</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-xs">Docker</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="mt-4 w-full text-blue-500 hover:text-blue-600 text-sm font-medium">
                            View All Jobs
                        </button>
                    </div>
            
                    <!-- Suggested Connections -->
                    <div class="bg-white rounded-xl shadow-sm p-4">
                        <h3 class="font-semibold mb-4">Suggested Connections</h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <img src="https://avatar.iran.liara.run/public/boy" alt="User" class="w-10 h-10 rounded-full"/>
                                    <div>
                                        <h4 class="font-medium">Emily Zhang</h4>
                                        <p class="text-gray-500 text-sm">Frontend Developer</p>
                                    </div>
                                </div>
                                <button class="text-blue-500 hover:text-blue-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.like-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const url = this.action;
            const method = this.querySelector('input[name="_method"]')?.value || 'POST';
            const token = this.querySelector('input[name="_token"]').value;
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });
                
                const data = await response.json();
                
                if (data.success) {
                    const button = this.querySelector('button');
                    const svg = button.querySelector('svg');
                    const count = button.querySelector('.likes-count');
                    
                    if (method === 'DELETE') {
                        // Change to like state
                        this.action = this.action.replace('unlike', 'like');
                        svg.classList.remove('text-blue-500');
                        svg.setAttribute('fill', 'none');
                        count.classList.remove('text-blue-500');
                        this.querySelector('input[name="_method"]')?.remove();
                    } else {
                        // Change to unlike state
                        this.action = this.action.replace('like', 'unlike');
                        const methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'DELETE';
                        this.appendChild(methodInput);
                        svg.classList.add('text-blue-500');
                        svg.setAttribute('fill', 'currentColor');
                        count.classList.add('text-blue-500');
                    }
                    
                    count.textContent = data.likes_count;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });

    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const postId = this.dataset.postId;
            const textarea = this.querySelector('textarea');
            const content = textarea.value.trim();
            
            if (!content) return;

            try {
                const response = await fetch(`/posts/${postId}/comment`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        content: content
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Clear textarea
                    textarea.value = '';
                    
                    // Add new comment to the list
                    const commentsList = document.getElementById(`commentsList-${postId}`);
                    const newComment = `
                        <div class="flex space-x-3">
                            <img src="${data.comment.user.profile_picture || 'https://avatar.iran.liara.run/public/boy'}" 
                                 alt="${data.comment.user.name}" 
                                 class="w-8 h-8 rounded-full"/>
                            <div class="flex-1">
                                <div class="bg-gray-50 rounded-lg px-4 py-2">
                                    <div class="font-medium text-sm">${data.comment.user.name}</div>
                                    <p class="text-sm text-gray-700">${data.comment.content}</p>
                                </div>
                                <div class="mt-1 flex items-center space-x-4 text-xs text-gray-500">
                                    <span>${data.comment.created_at}</span>
                                    <button class="hover:text-blue-500">Reply</button>
                                </div>
                            </div>
                        </div>
                    `;
                    commentsList.insertAdjacentHTML('afterbegin', newComment);

                    // Update comment count
                    const commentCount = document.querySelector(`#postStats-${postId} span:last-child`);
                    commentCount.textContent = parseInt(commentCount.textContent) + 1;
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });
    });
});

function toggleComments(commentsSectionId) {
    const commentsSection = document.getElementById(commentsSectionId);
    const postId = commentsSectionId.split('-')[1];
    const postStats = document.getElementById('postStats-' + postId);
    
    if (commentsSection.classList.contains('hidden')) {
        // Show comments
        commentsSection.classList.remove('hidden');
        postStats.classList.add('hidden'); // Hide the stats
    } else {
        // Hide comments
        commentsSection.classList.add('hidden');
        postStats.classList.remove('hidden'); // Show the stats
    }
}
</script>
