export const statusColorMap: Record<
    string,
    { bg: string; text: string; border: string }
> = {
    DRAFT: {
        bg: 'bg-slate-100 dark:bg-slate-900',
        text: 'text-slate-700 dark:text-slate-200',
        border: 'border-slate-300 dark:border-slate-700',
    },
    'READY-TO-SUBMITTED': {
        bg: 'bg-blue-100 dark:bg-blue-900',
        text: 'text-blue-700 dark:text-blue-200',
        border: 'border-blue-300 dark:border-blue-700',
    },
    SUBMITTED: {
        bg: 'bg-indigo-100 dark:bg-indigo-900',
        text: 'text-indigo-700 dark:text-indigo-200',
        border: 'border-indigo-300 dark:border-indigo-700',
    },
    'UNDER-REVIEW': {
        bg: 'bg-purple-100 dark:bg-purple-900',
        text: 'text-purple-700 dark:text-purple-200',
        border: 'border-purple-300 dark:border-purple-700',
    },
    'REVISION-REQUESTED': {
        bg: 'bg-amber-100 dark:bg-amber-900',
        text: 'text-amber-700 dark:text-amber-200',
        border: 'border-amber-300 dark:border-amber-700',
    },
    ACCEPTED: {
        bg: 'bg-emerald-100 dark:bg-emerald-900',
        text: 'text-emerald-700 dark:text-emerald-200',
        border: 'border-emerald-300 dark:border-emerald-700',
    },
    REJECTED: {
        bg: 'bg-red-100 dark:bg-red-900',
        text: 'text-red-700 dark:text-red-200',
        border: 'border-red-300 dark:border-red-700',
    },
    PUBLISHED: {
        bg: 'bg-green-100 dark:bg-green-900',
        text: 'text-green-700 dark:text-green-200',
        border: 'border-green-300 dark:border-green-700',
    },
}

export default statusColorMap
