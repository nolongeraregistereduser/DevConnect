<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notifications') }}
            </h2>
            @if($notifications->count() > 0)
                <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
                    @csrf
                    <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="flex items-start p-4 {{ $notification->read_at ? 'bg-white' : 'bg-indigo-50' }} rounded-lg border {{ $notification->read_at ? 'border-gray-200' : 'border-indigo-200' }}">
                                    <div class="flex-1">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $notification->data['message'] }}
                                            </p>
                                            <div class="ml-4 flex-shrink-0">
                                                @if(!$notification->read_at)
                                                    <form action="{{ route('notifications.markAsRead', $notification->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">
                                                            Mark as read
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <p class="text-gray-500 text-center">No notifications yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>