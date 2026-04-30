export interface Paper {
    id: string
    title: string
    status: string
    created_at: string
    updated_at: string
    contributors_count?: number
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

export interface PublicDashboardData {
    stats: PublicDashboardStats
    recent_papers: Paper[]
    recent_contributors: any[]
    status_distribution?: StatusDistributionItem[]
}
