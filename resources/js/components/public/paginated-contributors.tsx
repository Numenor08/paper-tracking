import React, { useEffect, useState } from 'react'
import { ContributorsList } from '@/components/public/contributors-list'
import type { Contributor } from '@/types'

export function PaginatedContributors({ initial }: { initial?: { data: Contributor[] } }) {
    const [items, setItems] = useState<Contributor[]>(initial?.data || [])
    const [page, setPage] = useState(1)
    const [perPage, setPerPage] = useState(10)
    const [search, setSearch] = useState('')
    const [loading, setLoading] = useState(false)
    const [lastPage, setLastPage] = useState(1)

    const fetchPage = async (p = page) => {
        setLoading(true)
        const params = new URLSearchParams()
        params.set('page', String(p))
        params.set('per_page', String(perPage))
        if (search) params.set('search', search)

        const res = await fetch(`/public/api/contributors?${params.toString()}`)
        const json = await res.json()
        setItems(json.data || json)
        setLastPage(json.last_page || 1)
        setLoading(false)
    }

    useEffect(() => {
        fetchPage(1)
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [perPage])

    useEffect(() => {
        const t = setTimeout(() => fetchPage(1), 300)
        return () => clearTimeout(t)
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [search])

    return (
        <div className="space-y-4 p-4">
            <div className="flex items-center justify-between">
                <div className="flex items-center gap-2">
                    <label className="text-sm text-neutral-600 dark:text-neutral-400">Show</label>
                    <select value={perPage} onChange={(e) => setPerPage(Number(e.target.value))} className="rounded border px-2 py-1">
                        <option value={5}>5</option>
                        <option value={10}>10</option>
                        <option value={25}>25</option>
                    </select>
                </div>
                <div>
                    <input
                        value={search}
                        onChange={(e) => setSearch(e.target.value)}
                        placeholder="Search contributors..."
                        className="rounded border px-3 py-1"
                    />
                </div>
            </div>

            <ContributorsList contributors={items} isLoading={loading} />

            <div className="flex items-center justify-between">
                <div className="text-sm text-neutral-600 dark:text-neutral-400">Page {page} of {lastPage}</div>
                <div className="flex items-center gap-2">
                    <button disabled={page <= 1} onClick={() => { setPage((p) => Math.max(1, p - 1)); fetchPage(page - 1) }} className="rounded border px-3 py-1 disabled:opacity-50">Prev</button>
                    <button disabled={page >= lastPage} onClick={() => { setPage((p) => p + 1); fetchPage(page + 1) }} className="rounded border px-3 py-1 disabled:opacity-50">Next</button>
                </div>
            </div>
        </div>
    )
}
