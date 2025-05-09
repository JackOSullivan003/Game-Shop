function selectRating(rating) {
    //display stars according to rating 
    let ratingValue = rating;
    let stars = document.querySelectorAll('.rating .fa-star');
    //debug log stars 
    console.log(stars);
    for (let i = 0; i < stars.length; i++) {
        stars[i].classList.remove('checked');
    }
    for (let i = 0; i < ratingValue; i++) {
        stars[i].classList.add('checked');
    }

    document.getElementById("rating").value = ratingValue;
}

document.addEventListener('DOMContentLoaded', function () {
  const reviewSection = document.getElementsByClassName('review-section')[1];  
  const textarea = document.getElementById('review-text'); 
  const loginButton = document.createElement('button');  // Create the login button
  loginButton.classList.add('login-button');
  
  // If not logged in, show the login message and button instead of the textarea
  if (!isLoggedIn) {
    // Hide the textarea and show a login message + button
    if (reviewSection) {
      reviewSection.innerHTML = ''; // Clear the review container
      const message = document.createElement('p');  // Create a paragraph with the message
      message.textContent = 'You must be signed in to leave a review. Please log in to continue.';

      loginButton.textContent = 'Go to Login Page';
      loginButton.addEventListener('click', function () {
        window.location.href = 'login.php';  // Redirect to your login page
      });

      // Append the message and the button to the review container
      reviewSection.appendChild(message);
      reviewSection.appendChild(loginButton);
    }
  } 
  
});