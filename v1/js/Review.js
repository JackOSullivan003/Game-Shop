function selectRating(rating) {
    // Get all stars and reset their color
    const stars = document.querySelectorAll('.stars .fa');
    stars.forEach((star, index) => {
        star.classList.remove('checked'); // Remove checked class
        if (index < rating) { // Add checked class up to the clicked star
            star.classList.add('checked');
        }
    });
    // Set the hidden input value to the selected rating
    document.getElementById('rating').value = rating;
}