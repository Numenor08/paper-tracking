import { useEffect } from 'react'
import { PublicHeader } from '@/components/public-header'
import { initializeTheme } from '@/hooks/use-appearance'

export default function PublicLayout({
    children,
}: {
    children: React.ReactNode
}) {
    // Ensure theme is initialized on client-side
    useEffect(() => {
        initializeTheme()
    }, [])

    return (
        <div className="flex min-h-screen flex-col bg-white dark:bg-neutral-950">
            <PublicHeader />
            <main className="flex-1">
                {children}
            </main>
            <footer className="border-t border-neutral-200 bg-neutral-50 py-8 dark:border-neutral-800 dark:bg-neutral-900">
                <div className="mx-auto max-w-7xl px-4 text-center text-sm text-neutral-600 dark:text-neutral-400 sm:px-6 lg:px-8">
                    <p>&copy; 2026 Paper Tracking. All rights reserved.</p>
                </div>
            </footer>
        </div>
    )
}
