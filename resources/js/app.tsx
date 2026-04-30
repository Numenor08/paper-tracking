import { createInertiaApp } from '@inertiajs/react'
import { Toaster } from '@/components/ui/sonner'
import { TooltipProvider } from '@/components/ui/tooltip'
import PublicLayout from '@/layouts/public-layout'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel'

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    layout: (name) => {
        switch (true) {
            case name === 'public-dashboard':
                return PublicLayout
            default:
                return PublicLayout
        }
    },
    strictMode: true,
    withApp(app) {
        return (
            <TooltipProvider delayDuration={0}>
                {app}
                <Toaster />
            </TooltipProvider>
        )
    },
    progress: {
        color: '#4B5563',
    },
})
