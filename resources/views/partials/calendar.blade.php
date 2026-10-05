            <div class="calendar-header">
                <a href="#" class="calendar-nav-btn" data-month="{{ $current->copy()->subMonth()->month }}" data-year="{{ $current->copy()->subMonth()->year }}">‹</a>
                <h3>{{ $current->translatedFormat('F Y') }}</h3>
                <a href="#" class="calendar-nav-btn" data-month="{{ $current->copy()->addMonth()->month }}" data-year="{{ $current->copy()->addMonth()->year }}">›</a>
            </div>

            <div class="calendar-grid">
                <div class="calendar-day-name">Sen</div>
                <div class="calendar-day-name">Sel</div>
                <div class="calendar-day-name">Rab</div>
                <div class="calendar-day-name">Kam</div>
                <div class="calendar-day-name">Jum</div>
                <div class="calendar-day-name">Sab</div>
                <div class="calendar-day-name">Min</div>

                @for ($i = 0; $i < $startDayOffset; $i++)
                    <div class="calendar-day empty" style="background: transparent; border: none;"></div>
                @endfor

                @for ($i = 1; $i <= $daysInMonth; $i++)
                    <div class="calendar-day">
                        <span>{{ $i }}</span>
                        @if (isset($bookedDays[$i]))
                            @foreach($bookedDays[$i] as $entry)
                                <small class="calendar-event {{ $entry['status'] === 'pending' ? 'event-pending' : 'event-approved' }}" title="{{ $entry['room'] }} ({{ $entry['status'] === 'pending' ? 'Menunggu' : 'Disetujui' }})" style="white-space: normal; line-height: 1.2; word-wrap: break-word;">{{ $entry['room'] }}</small>
                            @endforeach
                        @endif
                    </div>
                @endfor
            </div>

            <div class="calendar-legend">
                <span><i class="legend available"></i> Tersedia</span>
                <span><i class="legend pending"></i> Menunggu Konfirmasi</span>
                <span><i class="legend booked"></i> Disetujui</span>
            </div>
