

var slideIndex = 1;
var interval;

function plusSlides(n) {
    showSlides(slideIndex += n);
  }
  
  function currentSlide(n) {
      clearInterval(interval);
      interval=undefined;
      n=Number(n);
    showSlides(slideIndex = n);
  }

  function showSlides(n) {
      var i;
      let slides=document.querySelectorAll('.img-pc img');
  
    var dots = document.getElementsByClassName("dot");//controller
    if (n > slides.length) {slideIndex = 1}    
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }
    slides[slideIndex-1].style.display = "block";  
    dots[slideIndex-1].className += " active";

  }


showSlides(slideIndex);



//more btn
let handle=function(e){
let target=e.target;
let id=target.hash.replace("#","");

let more=document.getElementById(id);
    more.classList.toggle('show-more');
    target.innerHTML=more.classList.contains('show-more')?"See less":"See all";
};

let moreLink=document.querySelectorAll('.see-more');
  moreLink.forEach(elm=>{
      elm.addEventListener("click",handle);
  });

  let name=document.getElementById('name')
  name!==null?name.focus():"do nothing";//focus on the first input in the request form



function closeModal(e){
    e.preventDefault();
    document.querySelector('#modal-container').classList.add('d-none');
}
document.querySelector('.close').addEventListener('click',closeModal);
document.querySelector('.modal').addEventListener('click',function(e){

    if(e.target.classList.contains('modal')){
        closeModal(e);
    }
});

document.querySelector('.request-btn').addEventListener("click",function(e){
    e.preventDefault();
    document.querySelector('#modal-container').classList.remove('d-none');
});



//installment
function curencyComma(x){
    let parts=x.toString().split(".");
    parts[0]=parts[0].replace(/\B(?=(\d{3})+(?!\d))/g,",");
    return parts.join(".")
}


let range=document.getElementById('instalment_duration');

if
(range!=null){
    
let instalmentPer=document.getElementById('Instalment_per').value;
let instalmentPrice=document.getElementById('Instalment_price').value;
    
let instalVal=document.getElementById('instal_dur_value');
let initPrice=Math.ceil(Number(instalmentPrice)/Number(range.value));
    instalVal.innerHTML=`${curencyComma(initPrice)}/${instalmentPer} in ${Number(range.value)}`;
    
let showInstalmentPrice=document.getElementById('instalment_price_show');
    showInstalmentPrice.innerHTML=curencyComma(instalmentPrice)

range.addEventListener('change',function(e){
    let val=e.target.value;
    let price= Math.ceil(Number(instalmentPrice)/Number(val));
    
   instalVal.innerHTML=`${curencyComma(price)}/${instalmentPer} in ${val}`;
});


let instalmentPlan=document.getElementById('instalment-plan');

let radio=document.querySelectorAll('.instalment_plan input');
    
   radio.forEach(elm=>{
        elm.addEventListener('click',function(e){
            if(e.target.value==="instalment"){
                instalmentPlan.classList.remove('d-none');
            }else{
                instalmentPlan.classList.add('d-none');
            }
        });
    });

}