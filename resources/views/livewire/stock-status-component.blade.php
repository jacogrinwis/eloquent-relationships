<div>
    <span class="{{ $statusData['colors'] }} rounded px-2.5 py-0.5 text-xs font-bold">
        {{ $statusData['label'] }}
    </span>

    @if ($status === 2)
        {{-- <a
            href="#"
            class="ml-2 text-xs font-bold text-blue-800 underline"
        >
            {{ $statusData['info'] }}
        </a> --}}
    @endif
</div>
