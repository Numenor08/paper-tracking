export interface Paper {
    id: string
    title: string
    status: string
    created_at: string
    updated_at: string
    contributors: Contributor[]
    contributors_count?: number
}

export interface Contributor {
    id: string
    full_name: string
    pivot: Pivot
}

export interface Pivot {
    paper_id: string
    contributor_id: string
    role: string
    created_at: string
    updated_at: string
}

export interface PublicDashboardStats {
    total_papers: number
    total_contributors: number
    recent_activity_count: number
}

export interface StatusDistributionItem {
    status: string
    count: number
}

export interface PaperPagination {
    data: Paper[]
    current_page: number
    from: number | null
    last_page: number
    links: {
        url: string | null
        label: string
        active: boolean
    }[]
    per_page: number
    to: number | null
    total: number
}

export interface PublicDashboardData {
    stats: PublicDashboardStats
    recent_papers: PaperPagination
    status_distribution: StatusDistributionItem[]
    filters: {
        search: string
        per_page: number
    }
}
