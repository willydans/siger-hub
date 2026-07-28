<div class="max-h-96 overflow-y-auto">
    @if($activities->count() > 0)
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b sticky top-0 z-10">
                <tr>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">Perangkat</th>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">Waktu Login</th>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                @php
                    $ua = $activity->user_agent ?? '';

                    $deviceIcon = '💻';
                    $deviceLabel = 'Desktop / Laptop';
                    if (preg_match('/Mobile|Android|iPhone/i', $ua)) {
                        $deviceIcon = '📱';
                        $deviceLabel = 'Mobile';
                    } elseif (preg_match('/iPad|Tablet/i', $ua)) {
                        $deviceIcon = '📟';
                        $deviceLabel = 'Tablet';
                    }

                    $browser = 'Browser tidak dikenal';
                    if (preg_match('/Edg\//i', $ua)) {
                        $browser = 'Microsoft Edge';
                    } elseif (preg_match('/Chrome\//i', $ua)) {
                        $browser = 'Chrome';
                    } elseif (preg_match('/Firefox\//i', $ua)) {
                        $browser = 'Firefox';
                    } elseif (preg_match('/Safari\//i', $ua)) {
                        $browser = 'Safari';
                    }
                @endphp
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        <div class="flex items-center gap-2">
                            <span>{{ $deviceIcon }}</span>
                            <span>{{ $deviceLabel }} — {{ $browser }}</span>
                        </div>
                    </td>
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        {{ $activity->created_at->diffForHumans() }}
                    </td>
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">{{ $activity->ip_address ?? '-' }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center py-10">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p class="text-gray-500 text-sm">Belum ada riwayat login yang tercatat.</p>
        </div>
    @endif
</div>