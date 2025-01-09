const quantity_inputs = document.querySelectorAll(".quantity_input");
const subtotals = document.querySelectorAll(".price");
const prices = document.querySelectorAll(".unit_price");

for (var i = 0; i < quantity_inputs.length; i++) {
    const quantity_input = quantity_inputs[i];
    const subtotal = subtotals[i];
    const price = prices[i];

    quantity_input.addEventListener("input", event => {
        subtotal.textContent = "$" + parseFloat(quantity_input.value) * parseFloat(price.textContent);
    })
}