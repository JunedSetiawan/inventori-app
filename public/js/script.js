
    // select2 dropdown
    // CSRF Token

    // Function to initialize Select2
    function initializeSelect2(selInventoryId) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $("#" + selInventoryId).select2({
            ajax: {
                url: "/inventory/getInventory",
                type: "post",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        _token: CSRF_TOKEN,
                        search: params.term // search term
                    };
                },
                processResults: function(response) {
                    return {
                        results: response
                    };
                },
                cache: true
            }
        });
    }

    // dynamic add and remove fields
    $(document).ready(function() {
        var max_fields = 10;
        var wrapper = $(".AddRemove");
        var add_button = $("#add-btn");

        var x = 0;

        // Function to generate a unique ID
        function generateUniqueId(prefix) {
            return prefix + (new Date()).getTime() + x;
        }

        // Function to generate field index for name attribute
        function generateFieldIndex() {
            return x + (new Date()).getTime();
        }

        // Initialize Select2 for the initial element
        initializeSelect2(generateUniqueId('selInventoryId_'));

        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;

                // Increment the ID for the select element
                let selInventoryId = generateUniqueId('selInventoryId_');
                let fieldIndex = generateFieldIndex();

                // Append a new set of fields to the wrapper
                $(wrapper).append(
                    '<div class="space-x-3 border-2 rounded-md p-5 flex"><span class="flex flex-col"><label for=""> Inventory</label><select name="field[' +
                    fieldIndex +
                    '][inventori_id]" id="' +
                    selInventoryId +
                    '" class="rounded"><option value="" disabled selected>Select The Inventory..</option></select></span></span><span class="flex flex-col"><label for=""> Qty</label><input type="number" name="field[' +
                    fieldIndex +
                    '][qty]" id="qty_' + x +
                    '" class="rounded" placeholder="entry the Quantity field" min="0"></span><span class="flex flex-col"><label for=""> Price</label><input type="number" name="field[' +
                    fieldIndex +
                    '][price]" id="price_' + x +
                    '" class="rounded" placeholder="entry the Price field" min="0"></span><a href="#" class="remove_field btn btn-error mt-5">Remove</a></div>'
                );

                // Initialize Select2 on the new select element
                initializeSelect2(selInventoryId);
            } else {
                alert('You Reached the limits');
            }
        });

        // Initialize Select2 for existing elements
        $(wrapper).find('select[id^="selInventoryId_"]').each(function() {
            initializeSelect2($(this).attr('id'));
        });

        $(wrapper).on("click", ".remove_field", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        });
    });

