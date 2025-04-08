<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin: Live Streams') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">Currently Live Streams</h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('admin.livestreams.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to All Livestreams
                                </a>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Title</th>
                                                <th>User</th>
                                                <th>Started At</th>
                                                <th>Active</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($livestreams as $livestream)
                                                <tr>
                                                    <td>{{ $livestream->id }}</td>
                                                    <td>{{ $livestream->title }}</td>
                                                    <td>{{ $livestream->user->name }}</td>
                                                    <td>{{ $livestream->updated_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        @if($livestream->is_active)
                                                            <span class="badge bg-success">Yes</span>
                                                        @else
                                                            <span class="badge bg-danger">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('admin.livestreams.show', $livestream) }}" class="btn btn-sm btn-info">
                                                                <i class="fas fa-eye"></i> View
                                                            </a>
                                                            
                                                            <form action="{{ route('admin.livestreams.toggle-active', $livestream) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm {{ $livestream->is_active ? 'btn-warning' : 'btn-success' }}">
                                                                    <i class="fas {{ $livestream->is_active ? 'fa-ban' : 'fa-check' }}"></i> {{ $livestream->is_active ? 'Deactivate' : 'Activate' }}
                                                                </button>
                                                            </form>
                                                            
                                                            <form action="{{ route('admin.livestreams.end-live', $livestream) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="fas fa-stop-circle"></i> End Stream
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No live streams found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-center mt-4">
                                    {{ $livestreams->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>