import { Search } from 'lucide-react'
import React from 'react'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import type { ContributorFilters } from '@/types/contributor'

interface ContributorsToolbarProps {
    filters: ContributorFilters
    searchInputRef: React.RefObject<HTMLInputElement | null>
    onSearchSubmit: (event: React.FormEvent) => void
    onPerPageChange: (value: number) => void
}

export function ContributorsToolbar({
    filters,
    searchInputRef,
    onSearchSubmit,
    onPerPageChange,
}: ContributorsToolbarProps) {
    return (
        <div className="flex flex-col gap-3 border-b p-4 md:flex-row md:items-center md:justify-between">
            <form
                onSubmit={onSearchSubmit}
                className="flex w-full max-w-md items-center gap-2"
            >
                <div className="relative flex-1">
                    <Search className="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted-foreground" />
                    <Input
                        key={filters.search}
                        defaultValue={filters.search}
                        ref={searchInputRef}
                        placeholder="Cari nama, email, atau afiliasi"
                        className="pl-9"
                    />
                </div>
                <Button type="submit" variant="outline">
                    Search
                </Button>
            </form>

            <div className="flex items-center gap-2">
                <Label htmlFor="per_page" className="text-sm">
                    Per halaman
                </Label>
                <select
                    id="per_page"
                    className="h-9 rounded-md border bg-background px-3 text-sm"
                    value={filters.perPage}
                    onChange={(event) =>
                        onPerPageChange(Number(event.target.value))
                    }
                >
                    <option value={10}>10</option>
                    <option value={25}>25</option>
                    <option value={50}>50</option>
                </select>
            </div>
        </div>
    )
}
