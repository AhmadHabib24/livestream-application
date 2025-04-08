<?php

namespace App\Http\Controllers;

use App\Models\Livestream;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LivestreamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show', 'liveNow']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livestreams = Livestream::with('user')
            ->active()
            ->latest()
            ->paginate(12);

        return view('livestreams.index', compact('livestreams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd('here');
        return view('livestreams.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Generate a unique stream key
        $streamKey = Str::random(20);

        $livestream = Auth::user()->livestreams()->create([
            'title' => $request->title,
            'description' => $request->description,
            'stream_key' => $streamKey,
            'status' => 'pending',
        ]);

        return redirect()->route('livestreams.show', $livestream)
            ->with('success', 'Livestream created successfully! You can now go live.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Livestream $livestream)
    {
        // Check if livestream is active
        if (!$livestream->is_active) {
            abort(404);
        }

        return view('livestreams.show', compact('livestream'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Livestream $livestream)
    {
        // Only the owner can edit their livestream
        if (Auth::id() !== $livestream->user_id) {
            abort(403);
        }

        return view('livestreams.edit', compact('livestream'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Livestream $livestream)
    {
        // Only the owner can update their livestream
        if (Auth::id() !== $livestream->user_id) {
            abort(403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'description' => 'nullable|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $livestream->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('livestreams.show', $livestream)
            ->with('success', 'Livestream updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Livestream $livestream)
    {
        // Only the owner can delete their livestream
        if (Auth::id() !== $livestream->user_id) {
            abort(403);
        }

        $livestream->delete();

        return redirect()->route('livestreams.index')
            ->with('success', 'Livestream deleted successfully!');
    }

    /**
     * Start a livestream.
     */
    public function goLive(Livestream $livestream)
    {
        // Only the owner can start their livestream
        if (Auth::id() !== $livestream->user_id) {
            abort(403);
        }

        $livestream->update([
            'status' => 'live',
            // For YouTube or Vimeo embedding
            'stream_url' => 'https://www.youtube.com/embed/live_stream?channel=YOUR_CHANNEL_ID',
        ]);

        return redirect()->route('livestreams.show', $livestream)
            ->with('success', 'Your livestream is now live!');
    }

    /**
     * End a livestream.
     */
    public function endLive(Livestream $livestream)
    {
        // Only the owner can end their livestream
        if (Auth::id() !== $livestream->user_id) {
            abort(403);
        }

        $livestream->update([
            'status' => 'ended',
        ]);

        return redirect()->route('livestreams.index')
            ->with('success', 'Your livestream has ended.');
    }

    /**
     * Show currently live streams.
     */
    public function liveNow()
    {
        $liveStreams = Livestream::with('user')
            ->live()
            ->active()
            ->latest()
            ->paginate(12);

        return view('livestreams.live-now', compact('liveStreams'));
    }

    /**
     * Show my livestreams.
     */
    public function myLivestreams()
    {
        $livestreams = Auth::user()->livestreams()
            ->latest()
            ->paginate(12);

        return view('livestreams.my-livestreams', compact('livestreams'));
    }
}
