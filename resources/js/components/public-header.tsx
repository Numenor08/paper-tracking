import { Link } from '@inertiajs/react'
import { LayoutDashboard, Moon, Sun } from 'lucide-react'
import { useEffect } from 'react'
import { useAppearance, setGlobalAppearance } from '@/hooks/use-appearance'

export function PublicHeader() {
    // Use shared appearance hook so toggle stays in sync
    const { resolvedAppearance, updateAppearance } = useAppearance()

    useEffect(() => {
        // ensure resolvedAppearance is applied on mount (no-op if already set)
        updateAppearance(resolvedAppearance)
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [])

    const toggleTheme = () => {
        // Toggle between dark and light only
        const next = resolvedAppearance === 'dark' ? 'light' : 'dark'
        // Use global setter to ensure immediate DOM update and notify subscribers
        setGlobalAppearance(next)
    }

    return (
        <header className="border-b border-neutral-200 bg-white dark:border-neutral-800 dark:bg-neutral-900">
            <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                {/* Logo */}
                <Link href="/" className="flex items-center gap-2">
                    <img
                        src="/favicon.svg"
                        alt="Paper Tracking"
                        className="h-8 w-8"
                    />
                    <span className="text-xl font-semibold text-neutral-900 dark:text-white">
                        Paper Tracking
                    </span>
                </Link>

                {/* Right side - Theme toggle and Admin button */}
                <div className="flex items-center gap-4">
                    {/* Theme Toggle Button */}
                    <button
                        onClick={toggleTheme}
                        className="inline-flex h-9 w-9 items-center justify-center rounded-md border border-neutral-200 bg-white text-neutral-700 hover:bg-neutral-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-neutral-300 dark:hover:bg-neutral-700"
                        aria-label="Toggle theme"
                    >
                        {resolvedAppearance === 'dark' ? (
                            <Sun className="h-4 w-4" />
                        ) : (
                            <Moon className="h-4 w-4" />
                        )}
                    </button>

                    {/* Admin Link */}
                    <Link
                        href="/admin"
                        className="inline-flex items-center gap-2 rounded-md bg-amber-600 px-4 py-2 text-sm font-medium text-white hover:bg-amber-700 dark:bg-amber-700 dark:hover:bg-amber-600"
                    >
                        <LayoutDashboard className="h-4 w-4" />
                        <span>Admin</span>
                    </Link>
                </div>
            </div>
        </header>
    )
}
