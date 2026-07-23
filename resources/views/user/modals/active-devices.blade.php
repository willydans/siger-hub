<div class="max-h-96 overflow-y-auto">
    @if($sessions->count() > 0)
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b sticky top-0 z-10">
                <tr>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">Perangkat</th>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">Aktivitas Terakhir</th>
                    <th class="text-left py-2 px-3 font-semibold text-gray-600 text-[11px] uppercase tracking-wider">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        <div class="flex items-center gap-2">
                            @php
                                $deviceIcon = '💻';
                                if (strpos($session->device ?? '', 'Mobile') !== false) $deviceIcon = '📱';
                                elseif (strpos($session->device ?? '', 'Tablet') !== false) $deviceIcon = '📟';
                            @endphp
                            <span>{{ $deviceIcon }}</span>
                            <span>{{ $session->device ?? 'Unknown' }}</span>
                        </div>
                    </td>
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        {{ $session->last_activity->diffForHumans() }}
                    </td>
                    <td class="py-2.5 px-3 text-gray-700 text-sm">
                        <span class="bg-gray-100 px-2 py-0.5 rounded text-xs font-mono">{{ $session->ip_address ?? '-' }}</span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-3 bg-blue-50 border border-blue-200 rounded-lg p-3">
            <p class="text-xs text-blue-700 flex items-center gap-2">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Perangkat yang sedang Anda gunakan saat ini <strong>tidak ditampilkan</strong> dalam daftar ini.</span>
            </p>
        </div>
    @else
        <div class="text-center py-10">
            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            <p class="text-gray-500 text-sm">Tidak ada perangkat aktif lainnya.</p>
            <p class="text-gray-400 text-xs mt-1">Anda hanya login dari perangkat ini.</p>
        </div>
    @endif
</div>