<?php

namespace App\Http\Controllers;

use App\Models\Contributor;
use App\Models\Paper;
use App\Models\PaperStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Inertia\Inertia;

class PublicDashboardController extends Controller
{
    public function __invoke()
    {
        // Get total counts for stats
        $totalPapers = Paper::count();
        $totalContributors = Contributor::count();

        // Get recent activity count (status changes in last 30 days)
        $recentActivityCount = PaperStatusHistory::where('created_at', '>=', now()->subDays(30))->count();

        // Get recent papers (last 10, excluding drafts if applicable)
        $recentPapers = Paper::select([
            'id',
            'title',
            'status',
            'created_at',
            'updated_at',
        ])
            ->withCount('contributors')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(fn ($paper) => [
                'id' => $paper->id,
                'title' => $paper->title,
                'status' => $paper->status,
                'created_at' => $paper->created_at->toIso8601String(),
                'updated_at' => $paper->updated_at->toIso8601String(),
                'contributors_count' => $paper->contributors_count,
            ]);

        // Get recent contributors (last 10)
        $recentContributors = Contributor::select([
            'id',
            'full_name',
            'email',
            'affiliation',
        ])
            ->withCount('papers')
            ->latest('created_at')
            ->limit(10)
            ->get()
            ->map(fn ($contributor) => [
                'id' => $contributor->id,
                'full_name' => $contributor->full_name,
                'email' => $contributor->email,
                'affiliation' => $contributor->affiliation,
                'papers_count' => $contributor->papers_count,
            ]);

        // Status distribution for SSR render
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
            'recent_papers' => $recentPapers,
            'recent_contributors' => $recentContributors,
            'status_distribution' => $distribution,
        ]);
    }

    public function statistics()
    {
        $totalPapers = Paper::count();
        $totalContributors = Contributor::count();
        $recentActivityCount = PaperStatusHistory::where('created_at', '>=', now()->subDays(30))->count();

        return Response::json([
            'total_papers' => $totalPapers,
            'total_contributors' => $totalContributors,
            'recent_activity_count' => $recentActivityCount,
        ]);
    }

    public function papers(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search', null);
        $query = Paper::query()->select(['id', 'title', 'status', 'created_at'])->withCount('contributors');

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $paginator = $query->latest('created_at')->paginate($perPage)->withQueryString();

        return Response::json($paginator);
    }

    public function contributors(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        $search = $request->query('search', null);

        $query = Contributor::query()->select(['id', 'full_name', 'email', 'affiliation'])->withCount('papers');

        if ($search) {
            $query->where('full_name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
        }

        $paginator = $query->latest('created_at')->paginate($perPage)->withQueryString();

        return Response::json($paginator);
    }

    public function statusDistribution()
    {
        $distribution = Paper::query()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->map(fn ($r) => ['status' => $r->status, 'count' => (int) $r->count]);

        return Response::json($distribution);
    }
}
