<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contributors\StoreContributorRequest;
use App\Http\Requests\Contributors\UpdateContributorRequest;
use App\Models\Contributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContributorController extends Controller
{
    public function index(Request $request)
    {
        $allowedSorts = ['full_name', 'email', 'affiliation', 'created_at'];

        $sort = $request->input('sort', 'created_at');

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $direction = $request->input('direction', 'desc') === 'asc' ? 'asc' : 'desc';
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('perPage', 10);

        if (! in_array($perPage, [10, 25, 50], true)) {
            $perPage = 10;
        }

        $contributors = Contributor::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('full_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('affiliation', 'like', "%{$search}%");
                });
            })
            ->orderBy($sort, $direction)
            ->paginate($perPage)
            ->withQueryString();

        return inertia('Contributors/Index', [
            'contributors' => $contributors,
            'filters' => [
                'search' => $search,
                'sort' => $sort,
                'direction' => $direction,
                'perPage' => $perPage,
            ],
        ]);
    }

    public function store(StoreContributorRequest $request)
    {
        Contributor::create($request->validated());

        return Redirect::route('contributors.index')->with('success', 'Contributor created.');
    }

    public function update(UpdateContributorRequest $request, Contributor $contributor)
    {
        $contributor->update($request->validated());

        return Redirect::route('contributors.index')->with('success', 'Contributor updated.');
    }

    public function destroy(Contributor $contributor)
    {
        $contributor->delete();

        return Redirect::route('contributors.index')->with('success', 'Contributor deleted.');
    }
}
