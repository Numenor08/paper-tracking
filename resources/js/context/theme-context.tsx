import { useAppearance } from '@/hooks/use-appearance'

/**
 * Custom hook to access theme functionality
 * Uses the existing useAppearance hook which manages dark mode state
 */
export function useTheme() {
    return useAppearance()
}
