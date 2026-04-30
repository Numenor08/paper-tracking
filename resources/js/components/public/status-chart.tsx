import React from 'react'

export function StatusChart({ data }: { data: { status: string; count: number }[] }) {
    const total = data?.reduce((s, d) => s + (d.count || 0), 0) || 0

    if (!data || data.length === 0) {
        return (
            <div className="py-6 text-center text-sm text-neutral-600 dark:text-neutral-400">No distribution data available</div>
        )
    }

    return (
        <div className="space-y-3">
            {data.map((d) => {
                const pct = total > 0 ? Math.round((d.count / total) * 100) : 0
                return (
                    <div key={d.status} data-testid="status-row" className="flex items-center gap-4">
                        <div className="w-44 truncate text-sm font-medium text-neutral-700 dark:text-neutral-300">{d.status}</div>
                        <div className="flex-1">
                            <div className="h-3 w-full rounded-full bg-neutral-200 dark:bg-neutral-800">
                                <div
                                    className="h-3 rounded-full bg-amber-600 dark:bg-amber-500"
                                    style={{ width: `${pct}%` }}
                                />
                            </div>
                        </div>
                        <div className="w-12 text-right text-sm text-neutral-600 dark:text-neutral-400">{d.count}</div>
                    </div>
                )
            })}
        </div>
    )
}
