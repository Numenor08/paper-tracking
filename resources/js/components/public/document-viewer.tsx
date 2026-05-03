import { FileIcon, Download, Eye } from 'lucide-react'
import { cn } from '@/lib/utils'

interface DocumentViewerProps {
    document: {
        id: string
        file_name: string | null
        url: string | null
        preview_url?: string | null
        download_url?: string | null
        mime_type?: string | null
        size?: number | null
    }
}

function formatFileSize(bytes: number | null): string {
    if (!bytes) {
        return 'Unknown size'
    }

    const units = ['B', 'KB', 'MB', 'GB']
    let size = bytes
    let unitIndex = 0

    while (size >= 1024 && unitIndex < units.length - 1) {
        size /= 1024
        unitIndex++
    }

    return `${size.toFixed(2)} ${units[unitIndex]}`
}

function getFileType(mimeType: string | null | undefined): string {
    if (!mimeType) {
        return 'File'
    }

    if (mimeType.includes('pdf')) {
        return 'PDF'
    }

    if (mimeType.includes('word')) {
        return 'Word'
    }

    if (mimeType.includes('spreadsheet') || mimeType.includes('excel')) {
        return 'Spreadsheet'
    }

    if (mimeType.includes('presentation') || mimeType.includes('powerpoint')) {
        return 'Presentation'
    }

    if (mimeType.includes('text')) {
        return 'Text'
    }

    if (mimeType.includes('image')) {
        return 'Image'
    }

    return 'File'
}

function isPDF(mimeType: string | null | undefined): boolean {
    return mimeType?.includes('pdf') ?? false
}

export function DocumentViewer({ document }: DocumentViewerProps) {
    const isPdfFile = isPDF(document.mime_type)
    const fileType = getFileType(document.mime_type)

    // Debug: Log document info
    console.log('[DocumentViewer] Document:', {
        fileName: document.file_name,
        mimeType: document.mime_type,
        url: document.url,
        preview: document.preview_url,
        download: document.download_url,
        size: document.size,
        isPdf: isPdfFile,
    })

    if (
        !document.file_name ||
        !(document.download_url || document.url || document.preview_url)
    ) {
        return (
            <div className="rounded-lg border border-amber-200 bg-amber-50 p-4 dark:border-amber-900 dark:bg-amber-900/20">
                <p className="text-sm text-amber-800 dark:text-amber-200">
                    Document info incomplete. File:{' '}
                    {document.file_name ? '✓' : '✗'}, URL/Download/Preview:{' '}
                    {document.download_url ||
                    document.url ||
                    document.preview_url
                        ? '✓'
                        : '✗'}
                </p>
            </div>
        )
    }

    return (
        <div className="rounded-lg border border-neutral-200 bg-linear-to-br from-neutral-50 to-neutral-100 p-4 dark:border-neutral-800 dark:from-neutral-900 dark:to-neutral-800">
            <div className="flex items-start gap-4">
                <div className="flex h-12 w-12 items-center justify-center rounded-lg bg-primary/10">
                    <FileIcon className="h-6 w-6 text-primary" />
                </div>

                <div className="min-w-0 flex-1">
                    <h4 className="truncate font-medium text-neutral-900 dark:text-white">
                        {document.file_name ?? 'Document'}
                    </h4>
                    <p className="mt-1 text-sm text-neutral-600 dark:text-neutral-400">
                        {fileType} •{' '}
                        {formatFileSize(document.size ? document.size : null)}
                    </p>
                </div>

                <div className="flex items-center gap-2">
                    {isPdfFile && document.preview_url && (
                        <button
                            onClick={() =>
                                window.open(
                                    document.preview_url as string,
                                    '_blank',
                                )
                            }
                            className={cn(
                                'rounded-md bg-neutral-200 p-2 text-neutral-700 transition-colors hover:bg-neutral-300 dark:bg-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-600',
                            )}
                            title="Open preview in new tab"
                        >
                            <Eye className="h-4 w-4" />
                        </button>
                    )}

                    <a
                        href={document.download_url ?? document.url ?? '#'}
                        target="_blank"
                        rel="noopener noreferrer"
                        className="rounded-md bg-primary p-2 text-white transition-colors hover:bg-primary/90 dark:text-black"
                        title="Download"
                    >
                        <Download className="h-4 w-4" />
                    </a>
                </div>
            </div>
        </div>
    )
}
