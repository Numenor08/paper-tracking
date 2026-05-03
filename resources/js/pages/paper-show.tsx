import { Head, router, usePage } from '@inertiajs/react'
import { ArrowLeft } from 'lucide-react'
import type { FC } from 'react'
import { DocumentViewer } from '@/components/public/document-viewer'
import { formatDate } from '@/lib/date-utils'
import { statusColorMap } from '@/lib/status-map'
import { cn } from '@/lib/utils'

const PaperShow: FC = () => {
    const { paper } = usePage().props as any

    // Debug: Log paper data
    console.log('[PaperShow] Paper data:', {
        title: paper.title,
        hasDocument: !!paper.document,
        document: paper.document,
        urlAttachments: paper.url_attachments,
    })

    return (
        <>
            <Head title={`${paper.title} - Paper`} />

            <div className="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
                <button
                    onClick={() => router.get('/')}
                    className="mb-6 inline-flex cursor-pointer items-center gap-2 text-sm text-neutral-600 transition-colors hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-white"
                >
                    <ArrowLeft className="h-4 w-4" />
                    Back
                </button>

                <div className="mb-6 flex items-start justify-between gap-4">
                    <div>
                        <h1 className="text-3xl font-bold text-neutral-900 dark:text-white">
                            {paper.title}
                        </h1>
                        <p className="mt-2 text-sm text-neutral-600 dark:text-neutral-400">
                            {paper.index?.name ?? ''}
                        </p>
                    </div>

                    <div className="flex items-center gap-3">
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
                    <div className="col-span-2 space-y-6">
                        <div className="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <h2 className="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                Abstract
                            </h2>
                            <p className="mt-2 text-sm whitespace-pre-line text-neutral-600 dark:text-neutral-400">
                                {paper.abstract || 'No abstract provided.'}
                            </p>
                        </div>

                        <div className="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <h3 className="text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                                Attachments
                            </h3>
                            <div className="mt-4 space-y-4">
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
                    </div>

                    <aside className="col-span-1">
                        <div className="rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-800 dark:bg-neutral-900">
                            <div className="space-y-2 text-sm text-neutral-600 dark:text-neutral-400">
                                <div>
                                    <span className="block font-medium text-neutral-900 dark:text-white">
                                        Contributors
                                    </span>
                                    {paper.contributors?.length ? (
                                        <div className="mt-1">
                                            {paper.contributors.map(
                                                (c: any) => (
                                                    <div
                                                        key={c.id}
                                                        className="truncate"
                                                    >
                                                        {c.full_name}
                                                    </div>
                                                ),
                                            )}
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
