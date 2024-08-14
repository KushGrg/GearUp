// // let navbar=documnet.queryselector('.container');
// let userbox=document.querySelector('.container .account-box');
// document.querySelector('#user_btn').onclick= () => {
//     userbox.classList.toogle('active');
// }


let userBox = document.querySelector('.container .account-box');

document.querySelector('#user_btn').onclick = () => {
   console.log('User button clicked');
   userBox.classList.toggle('active'); 
}

window.onscroll = () => {
   console.log('Window scrolled');
   userBox.classList.remove('active');
}



