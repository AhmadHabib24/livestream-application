<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Livestreams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">My Livestreams</h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('livestreams.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Go Live
                                </a>
                            </div>
                        </div>

                        @if($livestreams->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($livestreams as $livestream)
                                            <tr>
                                                <td>{{ $livestream->title }}</td>
                                                <td>
                                                    @if($livestream->status === 'live')
                                                        <span class="badge bg-danger">LIVE</span>
                                                    @elseif($livestream->status === 'pending')
                                                        <span class="badge bg-warning text-dark">PENDING</span>
                                                    @elseif($livestream->status === 'ended')
                                                        <span class="badge bg-secondary">ENDED</span>
                                                    @endif
                                                </td>
                                                <td>{{ $livestream->created_at->format('M d, Y H:i') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('livestreams.show', $livestream) }}" class="btn btn-sm btn-info">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                        
                                                        @if($livestream->status === 'pending')
                                                            <form action="{{ route('livestreams.go-live', $livestream) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-broadcast-tower"></i> Go Live
                                                                </button>
                                                            </form>
                                                        @elseif($livestream->status === 'live')
                                                            <form action="{{ route('livestreams.end-live', $livestream) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-warning">
                                                                    <i class="fas fa-stop-circle"></i> End Stream
                                                                </button>
                                                            </form>
                                                        @endif
                                                        
                                                        <a href="{{ route('livestreams.edit', $livestream) }}" class="btn btn-sm btn-primary">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                        
                                                        <form action="{{ route('livestreams.destroy', $livestream) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this livestream?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                {{ $livestreams->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                You haven't created any livestreams yet.
                                <a href="{{ route('livestreams.create') }}">Go live now!</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>