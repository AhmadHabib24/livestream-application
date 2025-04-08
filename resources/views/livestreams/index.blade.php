<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('All Livestreams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">All Livestreams</h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('livestreams.live-now') }}" class="btn btn-danger">
                                    <i class="fas fa-broadcast-tower"></i> View Live Now
                                </a>
                                @auth
                                    <a href="{{route('livestreams.create')}}" class="btn btn-primary ms-2">
                                        <i class="fas fa-plus"></i> Go Live
                                    </a>
                                @endauth
                            </div>
                        </div>

                        @if($livestreams->count() > 0)
                            <div class="row">
                                @foreach($livestreams as $livestream)
                                    <div class="col-md-4">
                                        <div class="card livestream-card">
                                            <div class="position-relative">
                                                <img src="{{ $livestream->thumbnail ? asset('storage/' . $livestream->thumbnail) : 'https://via.placeholder.com/350x200?text=Livestream' }}" class="card-img-top" alt="{{ $livestream->title }}">
                                                
                                                @if($livestream->status === 'live')
                                                    <span class="badge status-badge-live livestream-badge">LIVE</span>
                                                @elseif($livestream->status === 'pending')
                                                    <span class="badge status-badge-pending livestream-badge">UPCOMING</span>
                                                @elseif($livestream->status === 'ended')
                                                    <span class="badge status-badge-ended livestream-badge">ENDED</span>
                                                @endif
                                            </div>
                                            
                                            <div class="card-body">
                                                <h5 class="card-title livestream-title">{{ $livestream->title }}</h5>
                                                <p class="card-text livestream-user">
                                                    <i class="fas fa-user"></i> {{ $livestream->user->name }}
                                                </p>
                                                <p class="card-text">
                                                    {{ Str::limit($livestream->description, 100) }}
                                                </p>
                                                <a href="{{ route('livestreams.show', $livestream) }}" class="btn btn-primary">
                                                    {{ $livestream->status === 'live' ? 'Watch Stream' : 'View Details' }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $livestreams->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                No livestreams available right now.
                                @auth
                                    <a href="{{ route('livestreams.create') }}">Be the first to go live!</a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>