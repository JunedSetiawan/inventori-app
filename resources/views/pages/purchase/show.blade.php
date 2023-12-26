<x-app-layout>

    <x-splade-modal>
        <section class="space-y-4">
            <h1 class="font-bold text-lg">Detail Purchases</h1>
            <ul class="menu bg-base-200 w-56 p-0 [&_li>*]:rounded-none">
                <li><a>Number : {{ $purchase->number }}</a></li>
                <li><a>User : {{ $purchase->user->name }}</a></li>
                <li><a>Date : {{ $purchase->date }}</a></li>
            </ul>
            @foreach ($purchase->purchaseDetail as $purchase_detail)
                <details class="collapse bg-base-200">
                    <summary class="collapse-title text-xl font-medium">{{ $purchase_detail->inventori->name }}</summary>
                    <div class="collapse-content">
                        <p>Inventory : {{ $purchase_detail->inventori->name }}</p>
                        <p>Qty : {{ $purchase_detail->qty }}</p>
                        <p>Price : @idr($purchase_detail->price)</p>
                        <p>Sub Total : @idr($purchase_detail->subTotal)</p>
                    </div>
                </details>
            @endforeach
        </section>
    </x-splade-modal>
</x-app-layout>
