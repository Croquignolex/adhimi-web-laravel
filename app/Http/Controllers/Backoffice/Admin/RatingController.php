<?php

namespace App\Http\Controllers\Backoffice\Admin;

use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Events\LogEvent;
use App\Models\Rating;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $q = $request->query('q');

        $query = Rating::allowed();

        $ratings = ($q)
            ? $query->search($q)->orderBy('note')->get()
            : $query->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.ratings.index', compact(['ratings', 'q']));
    }

    /**
     * Display the specified resource.
     *
     * @param Rating $rating
     * @return View
     */
    public function show(Rating $rating): View
    {
        return view('backoffice.admin.ratings.show', compact('rating'));
    }

    /**
     * Toggle rating status.
     *
     * @param Request $request
     * @param Rating $rating
     * @return RedirectResponse
     */
    public function statusToggle(Request $request, Rating $rating): RedirectResponse
    {
        $message = $rating->status_toggle['message'];
        $rating->update(['status' => $rating->status_toggle['next']]);

        LogEvent::dispatchUpdate($rating, $request, $message);

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param Rating $rating
     * @return View
     */
    public function showLogs(Rating $rating): View
    {
        $logs = $rating->logs()->allow()->orderBy('created_at', 'desc')->paginate();

        return view('backoffice.admin.ratings.show-logs', compact(['rating', 'logs']));
    }
}
