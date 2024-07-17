@php
    $nextStatus = null;
    $statusLabel = '';

    if ($status == 0) {
        // placed
        if ($paymentMethod == 'card') {
            $nextStatus = null;
            $statusLabel = 'Wait for being paid';
        } else {
            $nextStatusAccept = 1;
            $nextStatusReject = 2;
            $statusLabelAccept = 'Accept';
            $statusLabelReject = 'Reject';
        }
    } elseif ($status == 1) {
        // accepted
        $nextStatus = 3;
        $statusLabel = 'Mark as Prepared';
    } elseif ($status == 3) {
        // prepared
        $nextStatus = 4;
        $statusLabel = 'Mark as Delivered';
    } elseif ($status == 4) {
        // delivered
        if ($paymentMethod == 'cash') {
            $nextStatus = 5; // paid
            $statusLabel = 'Mark as Paid';
        } else {
            $nextStatus = 6; // closed
            $statusLabel = 'Close Order';
        }
    } elseif ($status == 5) {
        // paid
        if ($paymentMethod == 'cash') {
            $nextStatus = 6; // closed
            $statusLabel = 'Close Order';
        } else {
            $nextStatusAccept = 1;
            $nextStatusReject = 2;
            $statusLabelAccept = 'Accept';
            $statusLabelReject = 'Reject';
        }
    } else {
        $nextStatus = null;
        $statusLabel = '';
    }
@endphp

@if ($status == 0 && $paymentMethod == 'cash')
    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline-block">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="{{ $nextStatusAccept }}">
        <button type="submit"
            class="bg-green-600 dark:bg-green-800 text-white dark:text-white rounded px-3 py-1 transition duration-300 hover:bg-green-700 dark:hover:bg-green-900">
            {{ $statusLabelAccept }}
        </button>
    </form>
    <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline-block">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="{{ $nextStatusReject }}">
        <button type="submit"
            class="bg-red-600 dark:bg-red-800 text-white dark:text-white rounded px-3 py-1 transition duration-300 hover:bg-red-700 dark:hover:bg-red-900">
            {{ $statusLabelReject }}
        </button>
    </form>
@elseif ($status == 5)
    @if ($paymentMethod == 'card')
        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="{{ $nextStatusAccept }}">
            <button type="submit"
                class="bg-green-600 dark:bg-green-800 text-white dark:text-white rounded px-3 py-1 transition duration-300 hover:bg-green-700 dark:hover:bg-green-900">
                {{ $statusLabelAccept }}
            </button>
        </form>
        <form action="{{ route('orders.update', $order->id) }}" method="POST" class="inline-block">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="{{ $nextStatusReject }}">
            <button type="submit"
                class="bg-red-600 dark:bg-red-800 text-white dark:text-white rounded px-3 py-1 transition duration-300 hover:bg-red-700 dark:hover:bg-red-900">
                {{ $statusLabelReject }}
            </button>
        </form>
    @else
        <form action="{{ route('orders.update', $order->id) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="status" value="{{ $nextStatus }}">
            <button type="submit"
                class="bg-blue-600 dark:bg-blue-800 text-white dark:text-white rounded px-3 py-1 transition duration-300 hover:bg-blue-700 dark:hover:bg-blue-900">
                {{ $statusLabel }}
            </button>
        </form>
    @endif
@elseif ($statusLabel != '')
    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="{{ $nextStatus }}">
        <button type="submit"
            class="text-white dark:text-white rounded px-3 py-1 transition duration-300
        {{ $nextStatus == null ? 'bg-gray-400 dark:bg-gray-600 cursor-not-allowed' : 'bg-blue-600 dark:bg-blue-800 hover:bg-blue-700 dark:hover:bg-blue-900' }}"
            {{ $nextStatus == null ? 'disabled' : '' }}>
            {{ $statusLabel }}
        </button>
    </form>
@else
    <span class="text-gray-500 dark:text-gray-400">No further actions</span>
@endif
