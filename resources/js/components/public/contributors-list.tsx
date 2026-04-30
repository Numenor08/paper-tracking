import type { Contributor } from '@/types'

interface ContributorsListProps {
    contributors: Contributor[]
    isLoading?: boolean
}

export function ContributorsList({
    contributors,
    isLoading = false,
}: ContributorsListProps) {
    if (isLoading) {
        return (
            <div className="space-y-4">
                {[...Array(5)].map((_, i) => (
                    <div
                        key={i}
                        className="h-12 animate-pulse rounded-lg bg-neutral-200 dark:bg-neutral-800"
                    />
                ))}
            </div>
        )
    }

    if (contributors.length === 0) {
        return (
            <div className="rounded-lg border border-dashed border-neutral-300 p-8 text-center dark:border-neutral-700">
                <p className="text-sm text-neutral-600 dark:text-neutral-400">
                    No contributors available
                </p>
            </div>
        )
    }

    return (
        <div className="overflow-x-auto">
            <table className="w-full">
                <thead>
                    <tr className="border-b border-neutral-200 dark:border-neutral-800">
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Name
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Email
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Affiliation
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Papers
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {contributors.map((contributor) => (
                        <tr
                            key={contributor.id}
                            className="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-900/50"
                        >
                            <td className="px-4 py-3 text-sm font-medium text-neutral-900 dark:text-neutral-100">
                                {contributor.full_name}
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {contributor.email}
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {contributor.affiliation || '-'}
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {contributor.papers_count || 0}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    )
}
