
let deleteButtons = document.querySelectorAll('.delete-btn');
let deleteBox = document.querySelector('.delete-box');
// sets up a loop that iterates over each element in the deleteButtons ko collection.
deleteButtons.forEach(button => {
  button.addEventListener('click', function(e) {
 //  prevents the default behavior of the click event from occurring.
    e.preventDefault();
    deleteBox.classList.add('active');
    let deleteLink = this.getAttribute('href');

    let confirmButton = deleteBox.querySelector('.confirm-btn');
    let cancelButton = deleteBox.querySelector('.cancel-btn');

    confirmButton.addEventListener('click', function() {
      window.location.href = deleteLink;
    });

    cancelButton.addEventListener('click', function() {
      deleteBox.classList.remove('active');
    });
  });
});

window.addEventListener('scroll', function() {
  console.log('Window scrolled');
  deleteBox.classList.remove('active');
});

