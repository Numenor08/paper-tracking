import { Head, router, usePage } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'
import type { FC } from 'react'
import { useState } from 'react'
import { DocumentViewer } from '@/components/public/document-viewer'
import { formatDate, formatDateTime } from '@/lib/date-utils'
import { statusColorMap } from '@/lib/status-map'
import { cn } from '@/lib/utils'

type PaperContributor = {
    id: string
    full_name: string
    role: string | null
}

type StatusHistory = {
    id: number
    old_status: string
    new_status: string
    changed_at: string | null
    changed_by: {
        id: number
        name: string
    } | null
}

const getStatusBadgeClasses = (status: string): string => {
    return cn(
        'inline-flex w-fit shrink-0 items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap',
        statusColorMap[status]?.bg || 'bg-slate-100 dark:bg-slate-900',
        statusColorMap[status]?.text || 'text-slate-700 dark:text-slate-200',
        statusColorMap[status]?.border ||
            'border-slate-300 dark:border-slate-700',
    )
}

const formatContributorRole = (role: string | null): string => {
    if (!role) {
        return 'No role assigned'
    }

    return role.replaceAll('|', ', ')
}

const getContributorRoles = (role: string | null): string[] => {
    if (!role) {
        return []
    }

    return role
        .split('|')
        .map((entry) => entry.trim())
        .filter(Boolean)
}

type StatusHistorySectionProps = {
    paperId: string
    statusHistories: StatusHistory[]
}

const StatusHistorySection: FC<StatusHistorySectionProps> = ({
    paperId,
    statusHistories,
}) => {
    const statusHistoryPerPage = 5
    const [statusHistoryPage, setStatusHistoryPage] = useState(1)

    const totalStatusHistoryPages = Math.max(
        1,
        Math.ceil(statusHistories.length / statusHistoryPerPage),
    )

    const visibleStatusHistories = statusHistories.slice(
        (statusHistoryPage - 1) * statusHistoryPerPage,
        statusHistoryPage * statusHistoryPerPage,
    )
    const showingStart = Math.min(
        (statusHistoryPage - 1) * statusHistoryPerPage + 1,
        statusHistories.length,
    )
    const showingEnd = Math.min(
        statusHistoryPage * statusHistoryPerPage,
        statusHistories.length,
    )

    return (
        <div
            key={paperId}
            className="rounded-lg border border-neutral-200 bg-white p-4 sm:p-6 dark:border-neutral-800 dark:bg-neutral-900"
        >
            <h3 className="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                Status History
            </h3>

            {statusHistories.length ? (
                <>
                    {/* Desktop Table View */}
                    <div className="mt-4 hidden overflow-x-auto sm:block">
                        <table className="min-w-full divide-y divide-neutral-200 text-sm dark:divide-neutral-800">
                            <thead>
                                <tr className="text-left text-neutral-500 dark:text-neutral-400">
                                    <th className="pr-4 pb-3 font-medium">
                                        Changed At
                                    </th>
                                    <th className="pr-4 pb-3 font-medium">
                                        Old Status
                                    </th>
                                    <th className="pr-4 pb-3 font-medium">
                                        New Status
                                    </th>
                                    <th className="pr-4 pb-3 font-medium">
                                        Changed By
                                    </th>
                                </tr>
                            </thead>
                            <tbody className="divide-y divide-neutral-200 dark:divide-neutral-800">
                                {visibleStatusHistories.map((history) => (
                                    <tr key={history.id}>
                                        <td className="py-3 pr-4 whitespace-nowrap text-neutral-600 dark:text-neutral-400">
                                            {history.changed_at
                                                ? formatDateTime(
                                                      history.changed_at,
                                                  )
                                                : '-'}
                                        </td>
                                        <td className="py-3 pr-4">
                                            <span
                                                className={getStatusBadgeClasses(
                                                    history.old_status,
                                                )}
                                            >
                                                {history.old_status}
                                            </span>
                                        </td>
                                        <td className="py-3 pr-4">
                                            <span
                                                className={getStatusBadgeClasses(
                                                    history.new_status,
                                                )}
                                            >
                                                {history.new_status}
                                            </span>
                                        </td>
                                        <td className="py-3 pr-4 whitespace-nowrap text-neutral-600 dark:text-neutral-400">
                                            {history.changed_by?.name ??
                                                'Sistem'}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {/* Mobile Card View */}
                    <div className="mt-4 space-y-3 sm:hidden">
                        {visibleStatusHistories.map((history) => (
                            <div
                                key={history.id}
                                className="space-y-2 rounded-lg border border-neutral-200 bg-neutral-50 p-3 dark:border-neutral-800 dark:bg-neutral-800"
                            >
                                <div className="flex flex-col gap-1 sm:flex-row sm:items-start sm:justify-between">
                                    <span className="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                        {history.changed_at
                                            ? formatDateTime(history.changed_at)
                                            : '-'}
                                    </span>
                                    <span className="text-xs text-neutral-500 dark:text-neutral-400">
                                        by{' '}
                                        {history.changed_by?.name ?? 'Sistem'}
                                    </span>
                                </div>
                                <div className="space-y-1.5">
                                    <div>
                                        <span className="text-xs font-medium text-neutral-600 dark:text-neutral-400">
                                            Old Status:
                                        </span>
                                        <div className="mt-1">
                                            <span
                                                className={getStatusBadgeClasses(
                                                    history.old_status,
                                                )}
                                            >
                                                {history.old_status}
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <span className="text-xs font-medium text-neutral-600 dark:text-neutral-400">
                                            New Status:
                                        </span>
                                        <div className="mt-1">
                                            <span
                                                className={getStatusBadgeClasses(
                                                    history.new_status,
                                                )}
                                            >
                                                {history.new_status}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>

                    <div className="mt-4 flex flex-col gap-3 text-sm text-neutral-600 sm:flex-row sm:items-center sm:justify-between dark:text-neutral-400">
                        <div className="text-center sm:text-left">
                            Showing {showingStart} to {showingEnd} of{' '}
                            {statusHistories.length}
                        </div>

                        <div className="flex items-center justify-center gap-2">
                            <button
                                type="button"
                                onClick={() =>
                                    setStatusHistoryPage((current) =>
                                        Math.max(1, current - 1),
                                    )
                                }
                                disabled={statusHistoryPage === 1}
                                className="inline-flex items-center rounded-md border border-neutral-200 px-3 py-1.5 text-xs font-medium text-neutral-700 transition-colors hover:bg-neutral-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-800"
                            >
                                Previous
                            </button>

                            <span className="text-xs font-medium text-neutral-500 dark:text-neutral-400">
                                Page {statusHistoryPage} of{' '}
                                {totalStatusHistoryPages}
                            </span>

                            <button
                                type="button"
                                onClick={() =>
                                    setStatusHistoryPage((current) =>
                                        Math.min(
                                            totalStatusHistoryPages,
                                            current + 1,
                                        ),
                                    )
                                }
                                disabled={
                                    statusHistoryPage ===
                                    totalStatusHistoryPages
                                }
                                className="inline-flex items-center rounded-md border border-neutral-200 px-3 py-1.5 text-xs font-medium text-neutral-700 transition-colors hover:bg-neutral-50 disabled:cursor-not-allowed disabled:opacity-50 dark:border-neutral-800 dark:text-neutral-200 dark:hover:bg-neutral-800"
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </>
            ) : (
                <div className="mt-4 text-sm text-neutral-600 dark:text-neutral-400">
                    No status history available.
                </div>
            )}
        </div>
    )
}

const PaperShow: FC = () => {
    const { paper } = usePage().props as any
    const contributors = (paper.contributors ?? []) as PaperContributor[]
    const statusHistories = (paper.status_histories ?? []) as StatusHistory[]

    return (
        <>
            <Head title={`${paper.title} - Paper`} />

            <div className="mx-auto max-w-4xl overflow-x-clip px-4 py-6 sm:px-6 sm:py-12 lg:px-8">
                <button
                    onClick={() => router.get('/')}
                    className="mb-4 inline-flex cursor-pointer items-center gap-2 text-sm text-neutral-600 transition-colors hover:text-neutral-900 sm:mb-6 dark:text-neutral-400 dark:hover:text-white"
                >
                    <ArrowLeft className="h-4 w-4" />
                    Back
                </button>

                <div className="mb-4 flex flex-col gap-4 sm:mb-6 sm:flex-row sm:items-start sm:justify-between">
                    <div className="min-w-0 flex-1">
                        <h1 className="text-2xl font-bold wrap-break-word text-neutral-900 sm:text-3xl dark:text-white">
                            {paper.title}
                        </h1>
                        <p className="mt-2 truncate text-sm text-neutral-600 dark:text-neutral-400">
                            {paper.index?.name ?? ''}
                        </p>
                    </div>

                    <div className="flex shrink-0 items-center gap-3">
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
                    </div>
                </div>

                <div className="grid gap-6 md:grid-cols-3">
                    <div className="col-span-1 min-w-0 space-y-6 md:col-span-2">
                        <div className="rounded-lg border border-neutral-200 bg-white p-4 sm:p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <h2 className="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                Abstract
                            </h2>
                            <p className="mt-2 text-sm whitespace-pre-line text-neutral-600 dark:text-neutral-400">
                                {paper.abstract || 'No abstract provided.'}
                            </p>
                        </div>

                        <div className="rounded-lg border border-neutral-200 bg-white p-4 sm:p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <h3 className="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                Attachments
                            </h3>
                            <div className="mt-4 min-w-0 space-y-4">
                                {paper.document ? (
                                    <div className="space-y-4">
                                        <h4 className="text-xs font-medium text-neutral-600 uppercase dark:text-neutral-400">
                                            File Document
                                        </h4>
                                        <DocumentViewer
                                            document={paper.document}
                                        />
                                    </div>
                                ) : null}

                                {paper.url_attachments?.length ? (
                                    <div className="space-y-2">
                                        <h4 className="text-xs font-medium text-neutral-600 uppercase dark:text-neutral-400">
                                            Additional Links
                                        </h4>
                                        {paper.url_attachments.map((u: any) => (
                                            <a
                                                key={u.id}
                                                href={u.url}
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                className="block rounded border border-neutral-200 p-3 text-sm text-primary hover:bg-neutral-50 dark:border-neutral-800 dark:hover:bg-neutral-900/50"
                                            >
                                                {u.title ?? u.url}
                                            </a>
                                        ))}
                                    </div>
                                ) : !paper.document ? (
                                    <div className="text-sm text-neutral-600 dark:text-neutral-400">
                                        No attachments
                                    </div>
                                ) : null}
                            </div>
                        </div>

                        <StatusHistorySection
                            key={paper.id}
                            paperId={paper.id}
                            statusHistories={statusHistories}
                        />
                    </div>

                    <aside className="col-span-1 min-w-0 md:col-span-1">
                        <div className="rounded-lg border border-neutral-200 bg-white p-4 sm:p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <div className="min-w-0 space-y-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <div>
                                    <span className="block font-medium text-neutral-900 dark:text-white">
                                        Contributors
                                    </span>
                                    {contributors.length ? (
                                        <div className="mt-2 space-y-3">
                                            {contributors.map((contributor) => (
                                                <div
                                                    key={contributor.id}
                                                    className="min-w-0 space-y-1 rounded-md border border-neutral-200 px-3 py-2 dark:border-neutral-800"
                                                >
                                                    <div className="min-w-0 truncate font-medium text-neutral-900 dark:text-white">
                                                        {contributor.full_name}
                                                    </div>
                                                    <div className="flex flex-wrap gap-1.5">
                                                        {getContributorRoles(
                                                            contributor.role,
                                                        ).length ? (
                                                            getContributorRoles(
                                                                contributor.role,
                                                            ).map((role) => (
                                                                <span
                                                                    key={`${contributor.id}-${role}`}
                                                                    className="inline-flex w-fit rounded-full border border-neutral-200 bg-neutral-100 px-2 py-0.5 text-xs text-neutral-600 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300"
                                                                >
                                                                    {role}
                                                                </span>
                                                            ))
                                                        ) : (
                                                            <span className="inline-flex w-fit rounded-full border border-neutral-200 bg-neutral-100 px-2 py-0.5 text-xs text-neutral-600 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300">
                                                                {formatContributorRole(
                                                                    contributor.role,
                                                                )}
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                            ))}
                                        </div>
                                    ) : (
                                        <div className="mt-1 text-neutral-500">
                                            No Contributors
                                        </div>
                                    )}
                                </div>

                                <div>
                                    <span className="block font-medium text-neutral-900 dark:text-white">
                                        Created
                                    </span>
                                    <div className="mt-1">
                                        {formatDate(paper.created_at)}
                                    </div>
                                </div>

                                <div>
                                    <span className="block font-medium text-neutral-900 dark:text-white">
                                        Status
                                    </span>
                                    <div className="mt-2">
                                        <span
                                            className={cn(
                                                'inline-flex w-fit shrink-0 items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium whitespace-nowrap',
                                                statusColorMap[paper.status]
                                                    ?.bg ||
                                                    'bg-slate-100 dark:bg-slate-900',
                                                statusColorMap[paper.status]
                                                    ?.text ||
                                                    'text-slate-700 dark:text-slate-200',
                                                statusColorMap[paper.status]
                                                    ?.border ||
                                                    'border-slate-300 dark:border-slate-700',
                                            )}
                                        >
                                            {paper.status}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
        </>
    )
}

export default PaperShow
