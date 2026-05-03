import { Link } from '@inertiajs/react'
import { Fragment } from 'react'
import {
    Tooltip,
    TooltipContent,
    TooltipTrigger,
} from '@/components/ui/tooltip'
import { formatDate } from '@/lib/date-utils'
import { statusColorMap } from '@/lib/status-map'
import { cn } from '@/lib/utils'
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
                                <Link
                                    href={`/papers/${paper.id}`}
                                    className="font-medium hover:underline hover:brightness-150"
                                >
                                    {paper.title}
                                </Link>
                            </td>
                            <td className="px-4 py-3 text-sm">
                                <span
                                    className={cn(
                                        'inline-flex w-fit shrink-0 items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap',
                                        statusColorMap[paper.status]?.bg ||
                                            'bg-slate-100 dark:bg-slate-900',
                                        statusColorMap[paper.status]?.text ||
                                            'text-slate-700 dark:text-slate-200',
                                        statusColorMap[paper.status]?.border ||
                                            'border-slate-300 dark:border-slate-700',
                                    )}
                                >
                                    {paper.status}
                                </span>
                            </td>
                            <td className="px-4 py-3 text-sm text-neutral-600 dark:text-neutral-400">
                                {paper.contributors.length === 0 ? (
                                    <span className="text-sm text-neutral-600 dark:text-neutral-400">
                                        No Contributors
                                    </span>
                                ) : (
                                    paper.contributors.map(
                                        (contributor, index) => {
                                            const nameParts =
                                                contributor.full_name.split(' ')
                                            const showFullName =
                                                paper.contributors.length ===
                                                    1 || nameParts.length === 1
                                            const displayName = showFullName
                                                ? contributor.full_name
                                                : nameParts[0]
                                            const isLastItem =
                                                index ===
                                                paper.contributors.length - 1

                                            return (
                                                <Fragment
                                                    key={
                                                        contributor.id || index
                                                    }
                                                >
                                                    <Tooltip>
                                                        <TooltipTrigger className="hover:underline hover:brightness-150 focus:outline-none">
                                                            {displayName}
                                                        </TooltipTrigger>
                                                        <TooltipContent>
                                                            <div className="text-sm">
                                                                <p className="font-medium">
                                                                    {
                                                                        contributor.full_name
                                                                    }
                                                                </p>
                                                                {contributor
                                                                    .pivot
                                                                    ?.role && (
                                                                    <p className="text-xs text-neutral-400 capitalize">
                                                                        Role:{' '}
                                                                        {contributor.pivot.role
                                                                            .replace(
                                                                                /-/g,
                                                                                ' ',
                                                                            )
                                                                            .replace(
                                                                                /\|/g,
                                                                                ', ',
                                                                            )}
                                                                    </p>
                                                                )}
                                                            </div>
                                                        </TooltipContent>
                                                    </Tooltip>

                                                    {!isLastItem && (
                                                        <span className="mr-1">
                                                            ,
                                                        </span>
                                                    )}
                                                </Fragment>
                                            )
                                        },
                                    )
                                )}
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
