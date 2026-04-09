import { Head, router, useForm } from '@inertiajs/react'
import React, { useMemo, useRef, useState } from 'react'
import { route } from 'ziggy-js'
import { ContributorDeleteDialog } from '@/components/contributors/contributor-delete-dialog'
import { ContributorFormDialog } from '@/components/contributors/contributor-form-dialog'
import type { ContributorFormData } from '@/components/contributors/contributor-form-dialog'
import { ContributorsTable } from '@/components/contributors/contributors-table'
import { ContributorsToolbar } from '@/components/contributors/contributors-toolbar'
import type {
    Contributor,
    ContributorFilters,
    ContributorPagination,
} from '@/types/contributor.js'
import type { SortColumn, SortDirection } from '@/types/pagination'

export default function Index({
    contributors,
    filters,
}: {
    contributors: ContributorPagination
    filters: ContributorFilters
}) {
    const [open, setOpen] = useState(false)
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false)
    const [editingContributor, setEditingContributor] =
        useState<Contributor | null>(null)
    const [contributorToDelete, setContributorToDelete] =
        useState<Contributor | null>(null)
    const [isDeleting, setIsDeleting] = useState(false)
    const searchInputRef = useRef<HTMLInputElement>(null)

    const { data, setData, post, put, processing, errors, reset, clearErrors } =
        useForm<ContributorFormData>({
            full_name: '',
            email: '',
            affiliation: '',
            phone_number: '',
            address: '',
        })

    const buildIndexParams = (
        overrides?: Partial<ContributorFilters & { page: number }>,
    ) => {
        return {
            search: overrides?.search ?? filters.search,
            sort: overrides?.sort ?? filters.sort,
            direction: overrides?.direction ?? filters.direction,
            perPage: overrides?.perPage ?? filters.perPage,
            page: overrides?.page ?? contributors.current_page,
        }
    }

    const visitIndex = (
        overrides?: Partial<ContributorFilters & { page: number }>,
    ) => {
        router.get(route('contributors.index'), buildIndexParams(overrides), {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        })
    }

    const openCreateModal = () => {
        setEditingContributor(null)
        reset()
        clearErrors()
        setOpen(true)
    }

    const openEditModal = (contributor: Contributor) => {
        setEditingContributor(contributor)
        setData({
            full_name: contributor.full_name,
            email: contributor.email,
            affiliation: contributor.affiliation ?? '',
            phone_number: contributor.phone_number ?? '',
            address: contributor.address ?? '',
        })
        clearErrors()
        setOpen(true)
    }

    const resetDialog = () => {
        setOpen(false)
        setEditingContributor(null)
        reset()
        clearErrors()
    }

    const submitContributor = (e: React.FormEvent) => {
        e.preventDefault()

        if (editingContributor) {
            put(route('contributors.update', editingContributor.id), {
                preserveScroll: true,
                onSuccess: resetDialog,
            })

            return
        }

        post(route('contributors.store'), {
            preserveScroll: true,
            onSuccess: resetDialog,
        })
    }

    const submitSearch = (event: React.FormEvent) => {
        event.preventDefault()
        const nextSearch = searchInputRef.current?.value ?? ''
        visitIndex({ page: 1, search: nextSearch })
    }

    const openDeleteDialog = (contributor: Contributor) => {
        setContributorToDelete(contributor)
        setIsDeleteDialogOpen(true)
    }

    const closeDeleteDialog = () => {
        if (isDeleting) {
            return
        }

        setIsDeleteDialogOpen(false)
        setContributorToDelete(null)
    }

    const confirmDeleteContributor = () => {
        if (!contributorToDelete || isDeleting) {
            return
        }

        setIsDeleting(true)

        router.delete(route('contributors.destroy', contributorToDelete.id), {
            preserveScroll: true,
            onFinish: () => {
                setIsDeleting(false)
            },
            onSuccess: () => {
                setIsDeleteDialogOpen(false)
                setContributorToDelete(null)
            },
        })
    }

    const toggleSort = (column: SortColumn) => {
        const direction: SortDirection =
            filters.sort === column && filters.direction === 'asc'
                ? 'desc'
                : 'asc'

        visitIndex({ sort: column, direction, page: 1 })
    }

    const handleContributorFieldChange = (
        field: keyof ContributorFormData,
        value: string,
    ) => {
        setData(field, value)
    }

    const handleDeleteDialogOpenChange = (isOpen: boolean) => {
        if (!isOpen) {
            closeDeleteDialog()
        }
    }

    const totalRowsText = useMemo(() => {
        if (contributors.total === 0) {
            return 'Belum ada data contributor.'
        }

        const from = contributors.from ?? 0
        const to = contributors.to ?? 0

        return `Menampilkan ${from}-${to} dari ${contributors.total} contributor`
    }, [contributors.from, contributors.to, contributors.total])

    return (
        <div className="min-h-screen bg-muted/30 p-4 md:p-8">
            <Head title="Contributors" />

            <section className="mx-auto max-w-7xl space-y-6">
                <div className="rounded-2xl border bg-background p-6 shadow-sm">
                    <div className="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                        <div>
                            <h1 className="text-3xl font-semibold tracking-tight">
                                Contributors
                            </h1>
                            <p className="mt-1 text-sm text-muted-foreground">
                                Kelola data contributor dengan pengalaman tabel
                                yang cepat seperti Filament.
                            </p>
                        </div>

                        <ContributorFormDialog
                            open={open}
                            editingContributor={editingContributor}
                            data={data}
                            errors={errors}
                            processing={processing}
                            onOpenChange={(isOpen) =>
                                !isOpen ? resetDialog() : setOpen(true)
                            }
                            onCreateClick={openCreateModal}
                            onCancel={resetDialog}
                            onSubmit={submitContributor}
                            onFieldChange={handleContributorFieldChange}
                        />
                    </div>
                </div>

                <div className="rounded-2xl border bg-background shadow-sm">
                    <ContributorsToolbar
                        filters={filters}
                        searchInputRef={searchInputRef}
                        onSearchSubmit={submitSearch}
                        onPerPageChange={(perPage) =>
                            visitIndex({ perPage, page: 1 })
                        }
                    />

                    <ContributorsTable
                        contributors={contributors}
                        filters={filters}
                        totalRowsText={totalRowsText}
                        onSort={toggleSort}
                        onEdit={openEditModal}
                        onDelete={openDeleteDialog}
                    />
                </div>
            </section>

            <ContributorDeleteDialog
                open={isDeleteDialogOpen}
                contributor={contributorToDelete}
                isDeleting={isDeleting}
                onOpenChange={handleDeleteDialogOpenChange}
                onCancel={closeDeleteDialog}
                onConfirm={confirmDeleteContributor}
            />
        </div>
    )
}
