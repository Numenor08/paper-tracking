import { Plus } from 'lucide-react'
import React from 'react'
import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogHeader,
    DialogTitle,
    DialogTrigger,
} from '@/components/ui/dialog'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Textarea } from '@/components/ui/textarea'
import type { Contributor } from '@/types/contributor'

export interface ContributorFormData {
    full_name: string
    email: string
    affiliation: string
    phone_number: string
    address: string
}

interface ContributorFormDialogProps {
    open: boolean
    editingContributor: Contributor | null
    data: ContributorFormData
    errors: Partial<Record<keyof ContributorFormData, string>>
    processing: boolean
    onOpenChange: (isOpen: boolean) => void
    onCreateClick: () => void
    onCancel: () => void
    onSubmit: (event: React.FormEvent) => void
    onFieldChange: (field: keyof ContributorFormData, value: string) => void
}

export function ContributorFormDialog({
    open,
    editingContributor,
    data,
    errors,
    processing,
    onOpenChange,
    onCreateClick,
    onCancel,
    onSubmit,
    onFieldChange,
}: ContributorFormDialogProps) {
    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogTrigger asChild>
                <Button className="gap-2" onClick={onCreateClick}>
                    <Plus className="h-4 w-4" /> Tambah Data
                </Button>
            </DialogTrigger>
            <DialogContent className="sm:max-w-2xl">
                <DialogHeader>
                    <DialogTitle>
                        {editingContributor
                            ? 'Edit Contributor'
                            : 'Tambah Contributor'}
                    </DialogTitle>
                </DialogHeader>
                <form onSubmit={onSubmit} className="grid gap-4 py-4">
                    <div className="grid gap-2">
                        <Label htmlFor="full_name">Nama Lengkap</Label>
                        <Input
                            id="full_name"
                            value={data.full_name}
                            onChange={(event) =>
                                onFieldChange('full_name', event.target.value)
                            }
                        />
                        {errors.full_name && (
                            <span className="text-xs text-destructive">
                                {errors.full_name}
                            </span>
                        )}
                    </div>

                    <div className="grid gap-4 md:grid-cols-2">
                        <div className="grid gap-2">
                            <Label htmlFor="email">Email</Label>
                            <Input
                                type="email"
                                id="email"
                                value={data.email}
                                onChange={(event) =>
                                    onFieldChange('email', event.target.value)
                                }
                            />
                            {errors.email && (
                                <span className="text-xs text-destructive">
                                    {errors.email}
                                </span>
                            )}
                        </div>
                        <div className="grid gap-2">
                            <Label htmlFor="phone_number">Nomor HP</Label>
                            <Input
                                id="phone_number"
                                value={data.phone_number}
                                onChange={(event) =>
                                    onFieldChange(
                                        'phone_number',
                                        event.target.value,
                                    )
                                }
                            />
                            {errors.phone_number && (
                                <span className="text-xs text-destructive">
                                    {errors.phone_number}
                                </span>
                            )}
                        </div>
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="affiliation">Affiliation</Label>
                        <Input
                            id="affiliation"
                            value={data.affiliation}
                            onChange={(event) =>
                                onFieldChange('affiliation', event.target.value)
                            }
                        />
                        {errors.affiliation && (
                            <span className="text-xs text-destructive">
                                {errors.affiliation}
                            </span>
                        )}
                    </div>

                    <div className="grid gap-2">
                        <Label htmlFor="address">Address</Label>
                        <Textarea
                            id="address"
                            value={data.address}
                            onChange={(event) =>
                                onFieldChange('address', event.target.value)
                            }
                        />
                        {errors.address && (
                            <span className="text-xs text-destructive">
                                {errors.address}
                            </span>
                        )}
                    </div>

                    <div className="flex justify-end gap-2 pt-2">
                        <Button
                            type="button"
                            variant="outline"
                            onClick={onCancel}
                            disabled={processing}
                        >
                            Batal
                        </Button>
                        <Button type="submit" disabled={processing}>
                            {processing
                                ? 'Menyimpan...'
                                : editingContributor
                                  ? 'Simpan Perubahan'
                                  : 'Simpan Contributor'}
                        </Button>
                    </div>
                </form>
            </DialogContent>
        </Dialog>
    )
}
