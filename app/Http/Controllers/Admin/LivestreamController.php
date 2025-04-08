<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Livestream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivestreamController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->isAdmin()) {
                abort(403, 'Unauthorized action.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $livestreams = Livestream::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.livestreams.index', compact('livestreams'));
    }

    /**
     * Toggle livestream active status.
     */
    public function toggleActive(Livestream $livestream)
    {
        $livestream->update([
            'is_active' => !$livestream->is_active,
        ]);

        $status = $livestream->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.livestreams.index')
            ->with('success', "Livestream {$status} successfully!");
    }

    /**
     * Show live streams.
     */
    public function liveStreams()
    {
        $livestreams = Livestream::with('user')
            ->live()
            ->latest()
            ->paginate(20);

        return view('admin.livestreams.live', compact('livestreams'));
    }

    /**
     * Show livestream details.
     */
    public function show(Livestream $livestream)
    {
        return view('admin.livestreams.show', compact('livestream'));
    }

    /**
     * Force end a livestream.
     */
    public function endLive(Livestream $livestream)
    {
        $livestream->update([
            'status' => 'ended',
        ]);

        return redirect()->route('admin.livestreams.index')
            ->with('success', 'Livestream ended successfully.');
    }
}
