<div class="count-down d-inline-block">
    <div class="timer d-inline-block">
        <div>
            <div class="{{ $auction->status == AUCTION_STATUS_RUNNING ? 'lf-counter' : '' }}" data-time="{{$auction->ending_date->endOfDay()->unix() - now()->unix()}}">
                <div class="d-none"></div>
                @if($auction->ending_date->endOfDay()->unix() - now()->unix() >0)
                    <div class="day timer-unit">
                        <div class="d-flex timer-inner">
                            <span class="number">0</span>
                            <span class="number">0</span>
                        </div>
                        <div class="format">{{__('Days')}}</div>
                    </div>
                    <div class="hour timer-unit">
                        <div class="d-flex timer-inner">
                            <span class="number">0</span>
                            <span class="number">0</span>
                        </div>
                        <div class="format">{{__('Hours')}}</div>
                    </div>
                    <div class="min timer-unit">
                        <div class="d-flex timer-inner">
                            <span class="number">0</span>
                            <span class="number">0</span>
                        </div>
                        <div class="format">{{__('Minutes')}}</div>
                    </div>
                    <div class="sec timer-unit">
                        <div class="d-flex timer-inner">
                            <span class="number">0</span>
                            <span class="number">0</span>
                        </div>
                        <div class="format">{{__('Seconds')}}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
