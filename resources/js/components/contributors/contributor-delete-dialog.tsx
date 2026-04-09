import { Button } from '@/components/ui/button'
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog'
import type { Contributor } from '@/types/contributor'

interface ContributorDeleteDialogProps {
    open: boolean
    contributor: Contributor | null
    isDeleting: boolean
    onOpenChange: (isOpen: boolean) => void
    onCancel: () => void
    onConfirm: () => void
}

export function ContributorDeleteDialog({
    open,
    contributor,
    isDeleting,
    onOpenChange,
    onCancel,
    onConfirm,
}: ContributorDeleteDialogProps) {
    return (
        <Dialog open={open} onOpenChange={onOpenChange}>
            <DialogContent className="sm:max-w-md">
                <DialogHeader>
                    <DialogTitle>Hapus Contributor</DialogTitle>
                    <DialogDescription>
                        {contributor
                            ? `Anda yakin ingin menghapus ${contributor.full_name}? Tindakan ini tidak bisa dibatalkan.`
                            : 'Anda yakin ingin menghapus contributor ini? Tindakan ini tidak bisa dibatalkan.'}
                    </DialogDescription>
                </DialogHeader>

                <DialogFooter>
                    <Button
                        type="button"
                        variant="outline"
                        onClick={onCancel}
                        disabled={isDeleting}
                    >
                        Batal
                    </Button>
                    <Button
                        type="button"
                        variant="destructive"
                        onClick={onConfirm}
                        disabled={isDeleting}
                    >
                        {isDeleting ? 'Menghapus...' : 'Ya, Hapus'}
                    </Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    )
}
