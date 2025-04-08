<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Livestream') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">Edit Livestream</h1>
                            </div>
                            <div class="col-md-4 text-end">
                                <a href="{{ route('livestreams.my') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back to My Livestreams
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="{{ route('livestreams.update', $livestream) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="title" class="form-label">Stream Title</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $livestream->title) }}" required>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description', $livestream->description) }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Stream Key</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" value="{{ $livestream->stream_key }}" readonly>
                                                    <button type="button" class="btn btn-outline-primary" onclick="copyToClipboard('{{ $livestream->stream_key }}')">
                                                        <i class="fas fa-copy"></i> Copy
                                                    </button>
                                                </div>
                                                <small class="text-muted">Use this key in your streaming software (like OBS)</small>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    Update Livestream
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                alert('Stream key copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        }
    </script>
</x-app-layout>