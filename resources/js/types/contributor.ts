import type {
    PaginationLink,
    SortColumn,
    SortDirection,
} from '@/types/pagination'

export interface Contributor {
    id: string
    full_name: string
    email: string
    affiliation: string | null
    phone_number: string | null
    address: string | null
    created_at: string
    updated_at: string
}

export interface ContributorPagination {
    data: Contributor[]
    current_page: number
    from: number | null
    last_page: number
    links: PaginationLink[]
    per_page: number
    to: number | null
    total: number
}

export interface ContributorFilters {
    search: string
    sort: SortColumn
    direction: SortDirection
    perPage: number
}
