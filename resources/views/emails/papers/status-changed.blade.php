<p>Hello,</p>

<p>The status of a paper has been updated.</p>

<p>
    <strong>Paper:</strong> {{ $statusHistory->paper->title }}<br>
    <strong>Old Status:</strong> {{ $statusHistory->old_status }}<br>
    <strong>New Status:</strong> {{ $statusHistory->new_status }}<br>
    <strong>Changed By:</strong> {{ $statusHistory->changedBy->name ?? 'System' }}<br>
    <strong>Changed At:</strong> {{ $statusHistory->changed_at?->format('Y-m-d H:i:s') }}
</p>

<p>Thanks.</p>
