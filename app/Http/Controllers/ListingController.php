<?php

namespace App\Http\Controllers;

use App\Http\Middleware\NotSuspended;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ListingController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    private array $data = [];

    public static function middleware()
    {
        return [
            new Middleware(
                middleware: ['auth', 'verified',NotSuspended::class],except: ['index','show']
            )];
    }

    public function index()
    {
        $this->data['listings'] = Listing::
        whereHas('user', function (Builder $query) {
            $query->where('role', '!=', 'suspended');
        })->
        with('user')
            ->where('approved', true)
            ->filter(request(['search', 'user_id', 'tag']))
            ->latest()
            ->paginate(6)
            ->withQueryString();
        $this->data['searchTerm'] = request()->search;
        return Inertia::render('Home', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create',Listing::class);
        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create',Listing::class);
        $fields = $request->validate([
            'title' => 'required|max:255|min:2',
            'desc' => 'required',
            'tags' => 'string|nullable',
            'link' => 'url|nullable',
            'email' => 'email|nullable',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
        if ($request->hasFile('image')) {
            $fields['image'] = Storage::disk('public')->put('images/listings', $request->image);
        }
        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));
        $request->user()->listings()->create($fields);
        return redirect()->route('dashboard')->with('status', 'Listing has been created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
//        Gate::authorize('view', $listing);
        $this->data['listing'] = $listing;
        $this->data['user'] = $listing->user->only(['id', 'name']);
        $this->data['canModify'] = Auth::check() ?  request()->user()->can('modify', $listing) : false;
        return Inertia::render('Listing/Show', $this->data);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        Gate::authorize('modify', $listing);
        $this->data['listing'] = $listing;
        return Inertia::render('Listing/Edit', $this->data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('modify', $listing);
        $fields = $request->validate([
            'title' => 'required|max:255|min:2',
            'desc' => 'required',
            'tags' => 'string|nullable',
            'link' => 'url|nullable',
            'email' => 'email|nullable',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:3072',
        ]);
        if ($request->hasFile('image')) {
            if ($listing->image) {
                Storage::disk('public')->delete($listing->image);
            }
            $fields['image'] = Storage::disk('public')->put('images/listings', $request->image);
        } else {
            $fields['image'] = $listing->image;
        }
        $fields['tags'] = implode(',', array_unique(array_filter(array_map('trim', explode(',', $request->tags)))));
        $listing->update([...$fields,'approved'=>false]);
        return redirect()->route('dashboard')->with('status', 'Listing has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        Gate::authorize('modify', $listing);
        if ($listing->image) {
            Storage::disk('public')->delete($listing->image);
        }
        $listing->delete();
        return redirect()->route('dashboard')->with('status', 'Listing has been deleted.');
    }
}
