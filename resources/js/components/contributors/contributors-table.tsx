import { Link } from '@inertiajs/react'
import { ArrowDown, ArrowUp, ArrowUpDown, Pencil, Trash2 } from 'lucide-react'
import { Button } from '@/components/ui/button'
import type {
    Contributor,
    ContributorFilters,
    ContributorPagination,
} from '@/types/contributor'
import type { SortColumn, SortDirection } from '@/types/pagination'

interface ContributorsTableProps {
    contributors: ContributorPagination
    filters: ContributorFilters
    totalRowsText: string
    onSort: (column: SortColumn) => void
    onEdit: (contributor: Contributor) => void
    onDelete: (contributor: Contributor) => void
}

function cleanPaginationLabel(label: string): string {
    return label
        .replace(/&laquo;/g, '«')
        .replace(/&raquo;/g, '»')
        .replace(/<[^>]*>/g, '')
        .trim()
}

function getSortIcon(
    column: SortColumn,
    currentSort: SortColumn,
    direction: SortDirection,
) {
    if (currentSort !== column) {
        return <ArrowUpDown className="h-3.5 w-3.5" />
    }

    if (direction === 'asc') {
        return <ArrowUp className="h-3.5 w-3.5" />
    }

    return <ArrowDown className="h-3.5 w-3.5" />
}

function SortHeaderButton({
    label,
    column,
    filters,
    onSort,
}: {
    label: string
    column: SortColumn
    filters: ContributorFilters
    onSort: (column: SortColumn) => void
}) {
    return (
        <Button
            type="button"
            variant="ghost"
            size="sm"
            className="h-auto gap-1 px-0 py-0 text-xs font-semibold tracking-wider text-muted-foreground uppercase hover:bg-transparent"
            onClick={() => onSort(column)}
        >
            {label} {getSortIcon(column, filters.sort, filters.direction)}
        </Button>
    )
}

export function ContributorsTable({
    contributors,
    filters,
    totalRowsText,
    onSort,
    onEdit,
    onDelete,
}: ContributorsTableProps) {
    return (
        <>
            <div className="overflow-x-auto">
                <table className="min-w-full text-sm">
                    <thead className="bg-muted/40 text-left text-xs tracking-wider text-muted-foreground uppercase">
                        <tr>
                            <th className="px-4 py-3">
                                <SortHeaderButton
                                    label="Full Name"
                                    column="full_name"
                                    filters={filters}
                                    onSort={onSort}
                                />
                            </th>
                            <th className="px-4 py-3">
                                <SortHeaderButton
                                    label="Email"
                                    column="email"
                                    filters={filters}
                                    onSort={onSort}
                                />
                            </th>
                            <th className="px-4 py-3">
                                <SortHeaderButton
                                    label="Affiliation"
                                    column="affiliation"
                                    filters={filters}
                                    onSort={onSort}
                                />
                            </th>
                            <th className="px-4 py-3">Phone Number</th>
                            <th className="px-4 py-3">Address</th>
                            <th className="px-4 py-3">
                                <SortHeaderButton
                                    label="Created"
                                    column="created_at"
                                    filters={filters}
                                    onSort={onSort}
                                />
                            </th>
                            <th className="px-4 py-3 text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {contributors.data.length === 0 ? (
                            <tr>
                                <td
                                    colSpan={7}
                                    className="px-4 py-10 text-center text-muted-foreground"
                                >
                                    Tidak ada contributor yang cocok dengan
                                    filter saat ini.
                                </td>
                            </tr>
                        ) : (
                            contributors.data.map((contributor) => (
                                <tr
                                    key={contributor.id}
                                    className="border-t transition-colors hover:bg-muted/20"
                                >
                                    <td className="px-4 py-3 font-medium">
                                        {contributor.full_name}
                                    </td>
                                    <td className="px-4 py-3">
                                        {contributor.email}
                                    </td>
                                    <td className="px-4 py-3">
                                        {contributor.affiliation ?? '-'}
                                    </td>
                                    <td className="px-4 py-3">
                                        {contributor.phone_number ?? '-'}
                                    </td>
                                    <td className="max-w-sm truncate px-4 py-3">
                                        {contributor.address ?? '-'}
                                    </td>
                                    <td className="px-4 py-3 text-muted-foreground">
                                        {new Date(
                                            contributor.created_at,
                                        ).toLocaleDateString('id-ID')}
                                    </td>
                                    <td className="px-4 py-3">
                                        <div className="flex justify-end gap-1">
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                className="h-8 w-8"
                                                onClick={() =>
                                                    onEdit(contributor)
                                                }
                                            >
                                                <Pencil className="h-4 w-4" />
                                            </Button>
                                            <Button
                                                type="button"
                                                variant="ghost"
                                                size="icon"
                                                className="h-8 w-8 text-muted-foreground transition-colors hover:text-destructive"
                                                onClick={() =>
                                                    onDelete(contributor)
                                                }
                                            >
                                                <Trash2 className="h-4 w-4" />
                                            </Button>
                                        </div>
                                    </td>
                                </tr>
                            ))
                        )}
                    </tbody>
                </table>
            </div>

            <div className="flex flex-col gap-3 border-t p-4 md:flex-row md:items-center md:justify-between">
                <p className="text-sm text-muted-foreground">{totalRowsText}</p>

                <div className="flex flex-wrap gap-2">
                    {contributors.links.map((link, index) => {
                        const label = cleanPaginationLabel(link.label)

                        return link.url ? (
                            <Link
                                key={`${label}-${index}`}
                                href={link.url}
                                preserveState
                                preserveScroll
                                className={`rounded-md border px-3 py-1.5 text-sm transition-colors ${
                                    link.active
                                        ? 'border-primary bg-primary text-primary-foreground'
                                        : 'hover:bg-muted'
                                }`}
                            >
                                {label}
                            </Link>
                        ) : (
                            <span
                                key={`${label}-${index}`}
                                className="rounded-md border px-3 py-1.5 text-sm text-muted-foreground/60"
                            >
                                {label}
                            </span>
                        )
                    })}
                </div>
            </div>
        </>
    )
}
