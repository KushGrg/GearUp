

// let userbox = document.querySelector('.loginregister-box');

// document.querySelector('#lr_btn').onclick = () => {
//    console.log('User button clicked');
//    userbox.classList.toggle('active'); 
// }

// window.onscroll = () => {
//    console.log('Window scrolled');
//    userbox.classList.remove('active');
// }



let userbox = document.querySelector('.loginregister-box');
let lr_btn = document.querySelector('#lr_btn');

lr_btn.onclick = () => {
   console.log('User button clicked');
   userbox.classList.toggle('active'); 
}

window.onscroll = () => {
   console.log('Window scrolled');
   userbox.classList.remove('active');
}


// let userBox = document.querySelector('.container .account-box');

// document.querySelector('#user_btn').onclick = () => {
//    console.log('User button clicked');
//    userBox.classList.toggle('active'); 
// }

// window.onscroll = () => {
//    console.log('Window scrolled');
//    userBox.classList.remove('active');
// }



