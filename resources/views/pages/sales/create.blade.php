<x-app-layout>
    <x-slot name="headerNav">
        {{ __('Create Sales') }}
    </x-slot>


    <form class="bg-base-100 space-y-3 p-5 " action="{{ route('sales.store') }}" method="post">
        @csrf
        <section class="AddRemove items-center space-y-4">
            <span class=" flex flex-col">
                <label for=""> Date Sale</label>
                <input type="date" name="date" class="rounded" required value="">
            </span>
            <div class="space-x-3 border-2 rounded-md p-5 flex">
                <span class=" flex flex-col">
                    <label for=""> Inventory</label>
                    <select name="field[0][inventori_id]" id="selInventoryId_0" class="rounded" required>
                        <option value="" disabled selected>Select The Inventory..</option>
                    </select>
                </span>
                <span class=" flex flex-col">
                    <label for=""> Qty</label>
                    <input type="number" name="field[0][qty]" class="rounded" placeholder="entry the Quantity field"
                        min="0" required>
                </span>
                <span class=" flex flex-col">
                    <label for=""> Price</label>
                    <input type="number" name="field[0][price]" class="rounded" placeholder="entry the Price field"
                        min="1000" required>
                </span>
                <span class=" flex flex-col">
                    <label for="">.</label>
                    <button type="button" class="btn btn-neutral ml-2" id="add-btn">Add More</button>
                </span>
            </div>

        </section>

        <div class="flex justify-between">
            <button type="submit" class="btn btn-secondary">save</button>
        </div>
    </form>


</x-app-layout>
