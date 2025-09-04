<div class="card mt-4">
    <div class="card-header">
        <h5>Case History (Audit Trail)</h5>
    </div>
    <div class="card-body">
        <ul class="list-group">
            @foreach($case->trackingLogs as $log)
                <li class="list-group-item">
                    <strong>{{ $log->action }}</strong>  
                    @if($log->user) by <span class="text-primary">{{ $log->user->name }}</span> @endif  
                    <br>
                    <small class="text-muted">{{ $log->created_at->format('Y-m-d H:i') }}</small>
                    @if($log->details)  
                        <div><em>{{ $log->details }}</em></div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
