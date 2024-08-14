let deleteButtons = document.querySelectorAll('.delete-btn');
let deleteBox = document.querySelector('.delete-box');

deleteButtons.forEach(button => {
  button.addEventListener('click', function(e) {
    e.preventDefault();
    // console.log('Delete button clicked');
    deleteBox.classList.add('active');
    let deleteLink = this.getAttribute('href');
    // console.log('Delete link:', deleteLink);

    let confirmButton = deleteBox.querySelector('.confirm-btn');
    let cancelButton = deleteBox.querySelector('.cancel-btn');

    confirmButton.addEventListener('click', function() {
      console.log('Confirm button clicked');
      window.location.href = deleteLink;
    });

    cancelButton.addEventListener('click', function() {
      console.log('Cancel button clicked');
      deleteBox.classList.remove('active');
    });
  });
});

window.addEventListener('scroll', function() {
  console.log('Window scrolled');
  deleteBox.classList.remove('active');
});
