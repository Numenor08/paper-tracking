<div style="background-color: #f4f7fb; margin: 0; padding: 32px 0;">
    <div style="max-width: 640px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; font-family: Arial, Helvetica, sans-serif; color: #1f2937; box-shadow: 0 8px 30px rgba(15, 23, 42, 0.08);">
        <div style="padding: 28px 32px; background: linear-gradient(135deg, #0f766e 0%, #0ea5e9 100%); color: #ffffff;">
            <p style="margin: 0; font-size: 12px; letter-spacing: 0.08em; text-transform: uppercase; opacity: 0.9;">Notifikasi Sistem Paper Tracking</p>
            <h1 style="margin: 10px 0 0; font-size: 24px; line-height: 1.3;">Status paper berhasil diperbarui</h1>
        </div>

        <div style="padding: 32px; font-size: 15px; line-height: 1.7;">
            <p style="margin-top: 0;">Halo,</p>

            <p>
                Kami mengirimkan email ini untuk memberi tahu bahwa status sebuah paper telah berubah di aplikasi Paper Tracking.
                Perubahan ini tercatat agar semua pihak yang terkait dapat memantau riwayat perkembangan paper dengan lebih jelas.
            </p>

            <div style="margin: 28px 0; padding: 24px; border: 1px solid #e5e7eb; border-radius: 14px; background-color: #f9fafb;">
                <h2 style="margin: 0 0 16px; font-size: 18px; color: #0f172a;">Ringkasan perubahan</h2>

                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                    <tr>
                        <td style="padding: 8px 0; width: 180px; color: #6b7280; vertical-align: top;">Judul paper</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #0f172a;">{{ $statusHistory->paper->title }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; vertical-align: top;">Status sebelumnya</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #0f172a;">{{ $statusHistory->old_status }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; vertical-align: top;">Status saat ini</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #0f172a;">{{ $statusHistory->new_status }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; vertical-align: top;">Diubah oleh</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #0f172a;">{{ $statusHistory->changedBy->name ?? 'Sistem' }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 8px 0; color: #6b7280; vertical-align: top;">Waktu perubahan</td>
                        <td style="padding: 8px 0; font-weight: 600; color: #0f172a;">{{ $statusHistory->changed_at?->timezone(config('app.timezone'))->format('d/m/Y H:i') ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <p>
                Mohon gunakan informasi di atas sebagai referensi saat meninjau proses paper ini. Jika paper membutuhkan tindak lanjut, status terbaru di sistem akan menjadi acuan utama untuk langkah berikutnya.
            </p>

            <p style="margin-bottom: 0;">
                Terima kasih.<br>
                Tim Paper Tracking
            </p>
        </div>
    </div>
</div>
