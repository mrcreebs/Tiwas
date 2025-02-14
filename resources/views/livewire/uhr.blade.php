<div>
<div x-data="{ serverTime: '{{ $serverTime }}' }"
     x-init="setInterval(() => { $wire.refresh() }, {{ $interval }} )"
     class="flex items-center justify-center my-4"
     style="font-size: 40px; font-weight: bold;">
    <div class="text-4xl">{{ $serverTime }}</div>
</div>
<div class="text-sm text-center text-gray-500">{{ now()->format('d.m.Y') }}</div>
</div>
