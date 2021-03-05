<div class="shadow p-2 rounded-sm border border-gray-400 bg-white">
    <div class="font-bold border-b pb-2 flex justify-between">
        <div>
            <i class="red circle icon animate-pulse"></i>
            <span class="text-lg text-ease">{{ __('dispatchorders.live_dispatch_reports') }}</span>
        </div>
        <a href="{{ route('dispatchorders.daily') }}">
            <i class="fast shipping icon"></i>
            <span class="text-xs">Tümünü gör</span>
        </a>
    </div>
    <div class="pt-2">
        <div class="flex flex-col gap-2">
            @foreach ($this->liveReports as $report)
                <div class="p-2 flex justify-between hover:bg-gray-100 hover:shadow-md">
                    <div>
                        <i class="{{ $report['status']['icon'] }}"></i>
                        <span class="font-semibold">{{ $report['dispatchOrder']->company->cmp_commercial_title }}</span>
                        <span class="text-xs text-ease">({{ $report['dispatchOrder']->address->adr_name }})</span>
                        <span class="text-sm font-semibold {{ $report['status']['textColor'] }}">{{ $report['status']['explanation'] }}</span>
                    </div>
                    <div>
                        <span class="font-bold text-sm">{{ $report['dispatchOrder']->do_number }}</span>
                        <span class="pl-2">
                            <i wire:click="openDoDetailsModal({{ $report['dispatchOrder']->id }})" class="blue search link icon"></i>
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


    @if ($doDetailsModal)
        <div wire:key="doDetailsModal" x-data="{doDetailsModal: @entangle('doDetailsModal')}">
            <x-custom-modal active="doDetailsModal">
                <x-dispatchorder-details :dispatchOrder="$modalSelectedDispatchOrder" />
            </x-custom-modal>
        </div>
    @endif

</div>