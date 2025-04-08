<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: View Livestream') }}
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
                                    • 
                                    <span class="badge {{ $livestream->is_active ? 'bg-success' : 'bg-danger' }}">
                                        {{ $livestream->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('admin.livestreams.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to Livestreams
                                </a>
                                
                                <div class="btn-group mt-2">
                                    <form action="{{ route('admin.livestreams.toggle-active', $livestream) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn {{ $livestream->is_active ? 'btn-warning' : 'btn-success' }}">
                                            <i class="fas {{ $livestream->is_active ? 'fa-ban' : 'fa-check' }}"></i> {{ $livestream->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    
                                    @if($livestream->status === 'live')
                                        <form action="{{ route('admin.livestreams.end-live', $livestream) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-danger ms-2">
                                                <i class="fas fa-stop-circle"></i> End Stream
                                            </button>
                                        </form>
                                    @endif
                                </div>
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
                                                <p class="mb-0">The creator hasn't started the stream.</p>
                                            @else
                                                <h3 class="mb-3">This stream has ended</h3>
                                                <p class="mb-0">The stream is no longer live.</p>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Stream Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <strong>ID:</strong> {{ $livestream->id }}
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Status:</strong> 
                                                <span class="badge {{ $livestream->status === 'live' ? 'bg-danger' : ($livestream->status === 'pending' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                                    {{ strtoupper($livestream->status) }}
                                                </span>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Active:</strong> 
                                                <span class="badge {{ $livestream->is_active ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $livestream->is_active ? 'Yes' : 'No' }}
                                                </span>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Created At:</strong> {{ $livestream->created_at->format('M d, Y H:i') }}
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Updated At:</strong> {{ $livestream->updated_at->format('M d, Y H:i') }}
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <strong>Stream Key:</strong> {{ $livestream->stream_key }}
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <strong>Stream URL:</strong> {{ $livestream->stream_url ?: 'Not set' }}
                                            </div>
                                            <div class="col-md-12">
                                                <strong>Description:</strong> 
                                                <p class="mt-2">{{ $livestream->description ?: 'No description provided.' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">User Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="flex-shrink-0">
                                                <img src="https://via.placeholder.com/64" class="rounded-circle" alt="{{ $livestream->user->name }}">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h5 class="mb-1">{{ $livestream->user->name }}</h5>
                                                <p class="mb-0 text-muted">{{ $livestream->user->email }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-2">
                                            <strong>User ID:</strong> {{ $livestream->user->id }}
                                        </div>
                                        <div class="mb-2">
                                            <strong>Joined:</strong> {{ $livestream->user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="mb-0">
                                            <strong>Total Livestreams:</strong> {{ $livestream->user->livestreams()->count() }}
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0">Admin Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="{{ route('admin.livestreams.toggle-active', $livestream) }}" method="POST" class="mb-3">
                                            @csrf
                                            <div class="d-grid">
                                                <button type="submit" class="btn {{ $livestream->is_active ? 'btn-warning' : 'btn-success' }} btn-lg">
                                                    <i class="fas {{ $livestream->is_active ? 'fa-ban' : 'fa-check-circle' }}"></i> 
                                                    {{ $livestream->is_active ? 'Deactivate Livestream' : 'Activate Livestream' }}
                                                </button>
                                            </div>
                                        </form>
                                        
                                        @if($livestream->status === 'live')
                                            <form action="{{ route('admin.livestreams.end-live', $livestream) }}" method="POST">
                                                @csrf
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-danger btn-lg">
                                                        <i class="fas fa-stop-circle"></i> Force End Stream
                                                    </button>
                                                </div>
                                            </form>
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