import { Head, usePage } from '@inertiajs/react'
import { Users, FileText, TrendingUp } from 'lucide-react'
import { useEffect, useState } from 'react'
import { PaginatedContributors } from '@/components/public/paginated-contributors'
import { PaginatedPapers } from '@/components/public/paginated-papers'
import { StatsCard } from '@/components/public/stats-card'
import { StatusChart } from '@/components/public/status-chart'
import type { PublicDashboardData } from '@/types'

export default function PublicDashboard() {
    const { stats, recent_papers, recent_contributors, status_distribution } =
        usePage().props as unknown as PublicDashboardData

    const [distribution, setDistribution] = useState<
        { status: string; count: number }[]
    >(status_distribution || [])

    useEffect(() => {
        ;(async () => {
            try {
                const res = await fetch('/public/api/status-distribution')
                const json = await res.json()
                setDistribution(json)
            } catch {
                // ignore
            }
        })()
    }, [])

    return (
        <>
            <Head title="Public Dashboard - Paper Tracking" />
            <div className="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                {/* Hero Section */}
                <div className="mb-12">
                    <h1 className="text-4xl font-bold text-neutral-900 dark:text-white">
                        Paper Tracking Analytics
                    </h1>
                    <p className="mt-2 text-lg text-neutral-600 dark:text-neutral-400">
                        Real-time insights into our research papers and
                        contributors
                    </p>
                </div>

                {/* Stats Grid */}
                <div className="mb-12 grid gap-6 md:grid-cols-3">
                    <StatsCard
                        title="Total Papers"
                        value={stats.total_papers}
                        description="Active papers in the system"
                        icon={<FileText className="h-6 w-6" />}
                    />
                    <StatsCard
                        title="Total Contributors"
                        value={stats.total_contributors}
                        description="Registered contributors"
                        icon={<Users className="h-6 w-6" />}
                    />
                    <StatsCard
                        title="Recent Activity"
                        value={stats.recent_activity_count}
                        description="Status changes in last 30 days"
                        icon={<TrendingUp className="h-6 w-6" />}
                    />
                </div>

                {/* Data Tables Section */}
                <div className="grid gap-8 lg:grid-cols-3">
                    <div className="col-span-2 space-y-8">
                        <div>
                            <h2 className="mb-6 text-2xl font-bold text-neutral-900 dark:text-white">
                                Papers
                            </h2>
                            <div className="overflow-hidden rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900">
                                <PaginatedPapers
                                    initial={{ data: recent_papers }}
                                />
                            </div>
                        </div>

                        <div>
                            <h2 className="mb-6 text-2xl font-bold text-neutral-900 dark:text-white">
                                Contributors
                            </h2>
                            <div className="overflow-hidden rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900">
                                <PaginatedContributors
                                    initial={{ data: recent_contributors }}
                                />
                            </div>
                        </div>
                    </div>

                    <aside className="relative col-span-1">
                        <h3 className="mb-4 text-lg font-semibold text-neutral-900 dark:text-white">
                            Status Distribution
                        </h3>
                        <div className="sticky top-6 rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900">
                            <StatusChart data={distribution} />
                        </div>
                    </aside>
                </div>

                {/* CTA Section */}
                {/* <div className="mt-12 rounded-lg border border-amber-200 bg-amber-50 p-8 dark:border-amber-900 dark:bg-amber-950">
                    <h3 className="text-xl font-semibold text-amber-900 dark:text-amber-100">
                        Want to contribute?
                    </h3>
                    <p className="mt-2 text-amber-800 dark:text-amber-200">
                        Sign in to the admin dashboard to manage papers and
                        contributors.
                    </p>
                </div> */}
            </div>
        </>
    )
}

PublicDashboard.layout = null
