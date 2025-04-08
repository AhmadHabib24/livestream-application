<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Livestream') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="container">
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <h1 class="h3">Start a New Livestream</h1>
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
                                        <form action="{{ route('livestreams.store') }}" method="POST">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="title" class="form-label">Stream Title</label>
                                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="alert alert-info">
                                                <strong>Note:</strong> After creating your livestream, you'll get a unique stream key that you can use with OBS or another streaming software.
                                                <br>
                                                For testing, we'll use a YouTube/Vimeo embed.
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary btn-lg">
                                                    Create Livestream
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
</x-app-layout>