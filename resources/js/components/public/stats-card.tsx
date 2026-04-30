import React from 'react'

interface StatsCardProps {
    title: string
    value: string | number
    description?: string
    icon?: React.ReactNode
    className?: string
}

export function StatsCard({
    title,
    value,
    description,
    icon,
    className = '',
}: StatsCardProps) {
    return (
        <div
            className={`overflow-hidden rounded-lg border border-neutral-200 bg-white p-6 dark:border-neutral-800 dark:bg-neutral-900 ${className}`}
        >
            <div className="flex items-start justify-between">
                <div className="flex-1">
                    <p className="text-sm font-medium text-neutral-600 dark:text-neutral-400">
                        {title}
                    </p>
                    <p className="mt-2 text-3xl font-bold text-neutral-900 dark:text-white">
                        {value}
                    </p>
                    {description && (
                        <p className="mt-1 text-xs text-neutral-500 dark:text-neutral-500">
                            {description}
                        </p>
                    )}
                </div>
                {icon && (
                    <div className="ml-4 text-amber-600 dark:text-amber-500">
                        {icon}
                    </div>
                )}
            </div>
        </div>
    )
}
