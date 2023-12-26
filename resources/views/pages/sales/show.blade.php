<x-app-layout>

    <x-splade-modal>
        <section class="space-y-4">
            <h1 class="font-bold text-lg">Detail Sales</h1>
            <ul class="menu bg-base-200 w-56 p-0 [&_li>*]:rounded-none">
                <li><a>Number : {{ $sale->number }}</a></li>
                <li><a>User : {{ $sale->user->name }}</a></li>
                <li><a>Date : {{ $sale->date }}</a></li>
            </ul>
            @foreach ($sale->salesDetail as $sale_detail)
                <details class="collapse bg-base-200">
                    <summary class="collapse-title text-xl font-medium">{{ $sale_detail->inventori->name }}</summary>
                    <div class="collapse-content">
                        <p>Inventory : {{ $sale_detail->inventori->name }}</p>
                        <p>Qty : {{ $sale_detail->qty }}</p>
                        <p>Price : @idr($sale_detail->price)</p>
                        <p>Sub Total : @idr($sale_detail->subTotal)</p>
                    </div>
                </details>
            @endforeach
        </section>
    </x-splade-modal>
</x-app-layout>
