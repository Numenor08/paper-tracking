import { router, usePage } from '@inertiajs/react'
import { useCallback, useEffect, useState, useDeferredValue } from 'react'
import { route } from 'ziggy-js'
import { PapersList } from '@/components/public/papers-list'
import type { PublicDashboardData } from '@/types'

export function PaginatedPapers() {
    const { recent_papers, filters } = usePage()
        .props as unknown as PublicDashboardData
    const [search, setSearch] = useState<string>(filters.search)
    const [loading, setLoading] = useState(false)
    const deferredSearch = useDeferredValue(search)

    const visitDashboard = useCallback(
        (page: number, searchQuery: string, perPage?: number) => {
            router.get(
                route('public.dashboard'),
                {
                    page,
                    per_page: perPage ?? filters.per_page,
                    search: searchQuery,
                },
                {
                    preserveState: true,
                    preserveScroll: true,
                    replace: true,
                    only: ['recent_papers', 'filters'],
                    onStart: () => setLoading(true),
                    onFinish: () => setLoading(false),
                },
            )
        },
        [filters.per_page],
    )

    useEffect(() => {
        visitDashboard(1, deferredSearch)
    }, [deferredSearch, visitDashboard, filters.per_page])

    return (
        <div className="space-y-4 p-4">
            <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                    <label className="text-sm text-neutral-600 dark:text-neutral-400">
                        Show
                    </label>
                    <select
                        value={filters.per_page}
                        onChange={(e) => {
                            const selectedPerPage = Number(e.target.value)
                            visitDashboard(1, deferredSearch, selectedPerPage)
                        }}
                        className="rounded border px-2 py-1"
                    >
                        <option value={5}>5</option>
                        <option value={10}>10</option>
                        <option value={25}>25</option>
                    </select>
                </div>
                <div>
                    <input
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Search papers..."
                        className="rounded border px-3 py-1"
                    />
                </div>
            </div>

            <PapersList papers={recent_papers.data} isLoading={loading} />

            <div className="flex items-center justify-between">
                <div className="text-sm text-neutral-600 dark:text-neutral-400">
                    {`Page ${recent_papers.current_page} of ${recent_papers.last_page}`}
                </div>
                <div className="flex items-center gap-2">
                    <button
                        disabled={recent_papers.current_page <= 1 || loading}
                        onClick={() =>
                            visitDashboard(
                                recent_papers.current_page - 1,
                                deferredSearch,
                            )
                        }
                        className="rounded border px-3 py-1 disabled:opacity-50"
                    >
                        Prev
                    </button>
                    <button
                        disabled={
                            recent_papers.current_page >=
                                recent_papers.last_page || loading
                        }
                        onClick={() =>
                            visitDashboard(
                                recent_papers.current_page + 1,
                                deferredSearch,
                            )
                        }
                        className="rounded border px-3 py-1 disabled:opacity-50"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    )
}
