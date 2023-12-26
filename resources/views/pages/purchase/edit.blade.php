<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Edit Purchases') }}
    </x-slot>


    <form class="bg-base-100 space-y-3 p-5 " action="{{ route('purchase.update', $purchase->id) }}" method="POST">
        @method('PUT')
        @csrf
        <span class=" flex flex-col">
            <label for=""> Date Purchase</label>
            <input type="date" name="date" class="rounded" required value="{{ $purchase->date }}" id="date-purchase">
        </span>

        <section class="AddRemove items-center space-y-4">
            @if ($purchase->purchaseDetail->count() > 0)
                @foreach ($purchase->purchaseDetail as $index => $purchase_detail)
                    <div class="space-x-3 border-2 rounded-md p-5 flex">
                        <span class="flex flex-col">
                            <label for="selInventoryId_{{ $index }}"> Inventory</label>
                            <select name="field[{{ $index }}][inventori_id]"
                                id="selInventoryId_{{ $index }}" class="rounded" required>
                                <option value="{{ $purchase_detail->inventori_id }}" selected>
                                    {{ $purchase_detail->inventori->name }}</option>
                                <!-- Add options if needed -->
                            </select>
                        </span>
                        <span class="flex flex-col">
                            <label for="qty_{{ $index }}"> Qty</label>
                            <input type="number" name="field[{{ $index }}][qty]" id="qty_{{ $index }}"
                                class="rounded" value="{{ $purchase_detail->qty }}"
                                placeholder="Enter the Quantity field" min="0" required>
                        </span>
                        <span class="flex flex-col">
                            <label for="price_{{ $index }}"> Price</label>
                            <input type="number" name="field[{{ $index }}][price]"
                                id="price_{{ $index }}" class="rounded" value="{{ $purchase_detail->price }}"
                                placeholder="Enter the Price field" min="1000" required>
                        </span>
                        <a href="#" class="remove_field btn btn-error mt-5">Remove</a>
                    </div>
                @endforeach
            @endif

            <button type="button" class="btn btn-neutral ml-2" id="add-btn">Add More</button>


        </section>

        <div class="flex justify-between">
            <button type="submit" class="btn btn-secondary">save</button>
        </div>
    </form>


</x-app-layout>
