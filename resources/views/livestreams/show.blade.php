<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $livestream->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">{{ $livestream->title }}</h1>
                                <p class="text-muted">
                                    <i class="fas fa-user"></i> {{ $livestream->user->name }}
                                    • 
                                    <span class="badge {{ $livestream->status === 'live' ? 'bg-danger' : ($livestream->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                        {{ strtoupper($livestream->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('livestreams.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Livestreams
                                </a>
                                
                                @auth
                                    @if(Auth::id() === $livestream->user_id)
                                        @if($livestream->status === 'pending')
                                            <form action="{{ route('livestreams.go-live', $livestream) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger ms-2">
                                                    <i class="fas fa-broadcast-tower"></i> Go Live
                                                </button>
                                            </form>
                                        @elseif($livestream->status === 'live')
                                            <form action="{{ route('livestreams.end-live', $livestream) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning ms-2">
                                                    <i class="fas fa-stop-circle"></i> End Stream
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @endauth
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8">
                                @if($livestream->status === 'live')
                                    <div class="ratio ratio-16x9 mb-4">
                                        <iframe src="{{ $livestream->stream_url }}" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <div class="card mb-4">
                                        <div class="card-body text-center py-5">
                                            @if($livestream->status === 'pending')
                                                <h3 class="mb-3">This stream hasn't started yet</h3>
                                                <p class="mb-0">Check back later or subscribe to get notified when it goes live.</p>
                                            @else
                                                <h3 class="mb-3">This stream has ended</h3>
                                                <p class="mb-0">Check out other live streams or stay tuned for future broadcasts.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">About this stream</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>{{ $livestream->description ?: 'No description provided.' }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Streamer</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="https://via.placeholder.com/64" class="rounded-circle" alt="{{ $livestream->user->name }}">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-1">{{ $livestream->user->name }}</h5>
                                                <p class="mb-0 text-muted">Joined {{ $livestream->user->created_at->format('M Y') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Stream Info</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-2">
                                            <strong>Status:</strong>
                                            <span class="badge {{ $livestream->status === 'live' ? 'bg-danger' : ($livestream->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                                {{ strtoupper($livestream->status) }}
                                            </span>
                                        </p>
                                        <p class="mb-2">
                                            <strong>Created:</strong>
                                            {{ $livestream->created_at->format('M d, Y H:i') }}
                                        </p>
                                        
                                        @if($livestream->status !== 'pending')
                                            <p class="mb-0">
                                                <strong>Started:</strong>
                                                {{ $livestream->updated_at->format('M d, Y H:i') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>