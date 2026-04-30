import { formatDate } from '@/lib/date-utils'
import type { Paper } from '@/types'

interface PapersListProps {
    papers: Paper[]
    isLoading?: boolean
}

export function PapersList({ papers, isLoading = false }: PapersListProps) {
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

    if (papers.length === 0) {
        return (
            <div className="rounded-lg border border-dashed border-neutral-300 p-8 text-center dark:border-neutral-700">
                <p className="text-sm text-neutral-600 dark:text-neutral-400">
                    No papers available
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
                            Title
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Status
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Contributors
                        </th>
                        <th className="px-4 py-3 text-left text-sm font-semibold text-neutral-900 dark:text-white">
                            Date
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {papers.map((paper) => (
                        <tr
                            key={paper.id}
                            className="border-b border-neutral-100 hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-900/50"
                        >
                            <td className="px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100">
                                <span className="font-medium">{paper.title}</span>
                            </td>
                            <td className="px-4 py-3 text-sm">
                                <span className="inline-flex rounded-full bg-neutral-100 px-2.5 py-0.5 text-xs font-medium text-neutral-800 dark:bg-neutral-800 dark:text-neutral-200">
                                    {paper.status}
                                </span>
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {paper.contributors_count || 0}
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {formatDate(paper.created_at)}
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    )
}
