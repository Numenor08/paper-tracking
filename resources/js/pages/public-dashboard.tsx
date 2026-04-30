import { Head, usePage } from '@inertiajs/react'
import { Users, FileText, TrendingUp } from 'lucide-react'
import { PaginatedPapers } from '@/components/public/paginated-papers'
import { StatsCard } from '@/components/public/stats-card'
import { StatusChart } from '@/components/public/status-chart'
import type { PublicDashboardData } from '@/types'

export default function PublicDashboard() {
    const { stats, status_distribution } = usePage()
        .props as unknown as PublicDashboardData

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
                        <h2 className="mb-6 text-2xl font-bold text-neutral-900 dark:text-white">
                            Papers
                        </h2>
                        <div className="overflow-hidden rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900">
                            <PaginatedPapers />
                        </div>
                    </div>

                    <div className="relative col-span-1">
                        <h2 className="mb-6 text-2xl font-bold text-neutral-900 dark:text-white">
                            Status Distribution
                        </h2>
                        <div className="top-6 rounded-lg border border-neutral-200 bg-white p-4 dark:border-neutral-800 dark:bg-neutral-900">
                            <StatusChart data={status_distribution} />
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

PublicDashboard.layout = null
