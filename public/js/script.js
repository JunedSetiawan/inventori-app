// $(document).ready(function() {
//         var max_fields = 10;
//         var wrapper = $(".AddRemove");
//         var add_button = $("#add-btn");

//         var x = 1;
//         $(add_button).click(function(e) {
//             e.preventDefault();
//             if (x < max_fields) {
//                 x++;
//                 $(wrapper).append(
//                     '<div class="space-x-3 shadow-lg p-5 flex"><span class=" flex flex-col"><label for=""> Inventory</label><select name="" id=""></select></span><span class=" flex flex-col"><label for=""> Date Sale</label><input type="date" name="field[0][date]" class="rounded"></span><span class=" flex flex-col"><label for=""> Qty</label><input type="number" name="field[0][qty]" class="rounded" placeholder="entry the Quantity field"min="0"></span><span class=" flex flex-col"><label for=""> Price</label><input type="number" name="field[0][price]" class="rounded" placeholder="entry the Price field" min="0"></span><a href="#" class="remove_field btn btn-error mt-4">Remove</a></div>'
//                 );
//             } else {
//                 alert('You Reached the limits')
//             }
//         });

//         $(wrapper).on("click", ".remove_field", function(e) {
//             e.preventDefault();
//             $(this).parent('div').remove();
//             x--;
//         })
//     });