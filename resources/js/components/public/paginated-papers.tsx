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
                route('dashboard'),
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
            {/* Controls - Stack on mobile */}
            <div className="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                <div className="flex flex-col items-start gap-2 sm:flex-row sm:items-center">
                    <label className="text-sm text-neutral-600 dark:text-neutral-400">
                        Show
                    </label>
                    <select
                        value={filters.per_page}
                        onChange={(e) => {
                            const selectedPerPage = Number(e.target.value)
                            visitDashboard(1, deferredSearch, selectedPerPage)
                        }}
                        className="rounded border border-neutral-200 px-2 py-1.5 text-sm dark:border-neutral-800 dark:bg-neutral-800"
                    >
                        <option value={5}>5</option>
                        <option value={10}>10</option>
                        <option value={25}>25</option>
                    </select>
                </div>
                <div className="w-full sm:w-auto">
                    <input
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Search papers..."
                        className="w-full rounded border border-neutral-200 px-3 py-1.5 text-sm sm:w-auto dark:border-neutral-800 dark:bg-neutral-800"
                    />
                </div>
            </div>

            <PapersList papers={recent_papers.data} isLoading={loading} />

            {/* Pagination - Stack on mobile */}
            <div className="space-y-3 sm:flex sm:items-center sm:justify-between sm:space-y-0">
                <div className="text-center text-sm text-neutral-600 sm:text-left dark:text-neutral-400">
                    {`Page ${recent_papers.current_page} of ${recent_papers.last_page}`}
                </div>
                <div className="flex items-center justify-center gap-2">
                    <button
                        disabled={recent_papers.current_page <= 1 || loading}
                        onClick={() =>
                            visitDashboard(
                                recent_papers.current_page - 1,
                                deferredSearch,
                            )
                        }
                        className="rounded border border-neutral-200 px-3 py-1.5 text-sm transition-colors hover:bg-neutral-50 disabled:opacity-50 dark:border-neutral-800 dark:hover:bg-neutral-800"
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
                        className="rounded border border-neutral-200 px-3 py-1.5 text-sm transition-colors hover:bg-neutral-50 disabled:opacity-50 dark:border-neutral-800 dark:hover:bg-neutral-800"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>
    )
}
