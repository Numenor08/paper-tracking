export type SortColumn = 'full_name' | 'email' | 'affiliation' | 'created_at'
export type SortDirection = 'asc' | 'desc'

export interface PaginationLink {
    url: string | null
    label: string
    active: boolean
}
