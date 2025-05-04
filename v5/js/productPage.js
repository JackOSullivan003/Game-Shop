function updateQuantity(change) {
    qtyinput = document.getElementById('quantity');
    let quantity = parseInt(qtyinput.value);
    quantity += change;
    if (quantity < 1) quantity = 1;
    qtyinput.value = quantity;
}

function addToCart(productId) {
    qtyinput = document.getElementById('quantity');
    let quantity = qtyinput.value;
    fetch(`?action=addtocart&id=${productId}&quantity=${quantity}`)
    .then(response => response.json())
    .then(data => {
        console.log("Data from PHP:", data);  // Log the parsed response data

        if (data.success) {
            // Display "Added to Cart" message
            document.getElementById('cart-message').style.display = 'block';
            setTimeout(() => document.getElementById('cart-message').style.display = 'none', 2000);

            // Optionally, update UI or perform other actions based on the response
            console.log('Item added to cart:', data.message);
            //reload the cart number 
            document.getElementById('cartCount').innerHTML = data.cartCount;
        } else {
            // Handle error case
            alert(data.message); // Show message in alert box if something went wrong
        }
    })
    .catch(error => {
        console.log('Error:', error);
        alert('An error occurred while adding to cart');
    });
}