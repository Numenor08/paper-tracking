<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Paper;
use App\Models\PaperStatusHistory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicDashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = trim((string) $request->input('search', ''));
        $perPage = (int) $request->input('per_page', 10);

        if (! in_array($perPage, [5, 10, 25], true)) {
            $perPage = 10;
        }

        $totalPapers = Paper::count();
        $totalContributors = Contributor::count();

        $recentActivityCount = PaperStatusHistory::where('created_at', '>=', now()->subDays(30))->count();

        $paginatedPapers = Paper::select(['id', 'title', 'status', 'created_at']) // 'id' wajib ada
            ->with('contributors:id,full_name')
            ->withCount('contributors')
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->paginate($perPage)
            ->withQueryString();

        $distribution = Paper::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->map(fn ($r) => ['status' => $r->status, 'count' => (int) $r->count]);

        return Inertia::render('public-dashboard', [
            'stats' => [
                'total_papers' => $totalPapers,
                'total_contributors' => $totalContributors,
                'recent_activity_count' => $recentActivityCount,
            ],
            'recent_papers' => $paginatedPapers,
            'status_distribution' => $distribution,
            'filters' => [
                'search' => $search,
                'per_page' => $perPage,
            ],
        ]);
    }
}
