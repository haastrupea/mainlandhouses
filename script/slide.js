
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
        document.querySelector('#gallery-modal').classList.add('d-none');

        resetGallery()
    }
    //need to change this
    document.querySelectorAll('.close').forEach(el=>{
        el.addEventListener('click',closeModal)
    });
    document.querySelectorAll('.modal').forEach(el=>{
        el.addEventListener('click',function(e){
    
            if(e.target.classList.contains('modal')){
                closeModal(e);
            }
        });
    });
    
    document.querySelector('.request-btn').addEventListener("click",function(e){
        e.preventDefault();
        document.querySelector('#modal-container').classList.remove('d-none');
    });

    





  function heroSlide(n) {
    var dots = document.getElementsByClassName("dot");//controller
    let heroSlides=document.querySelectorAll('.img-pc img');
        showSlides(heroSlides,n)
    for (i = 0; i < dots.length; i++) {
        dots[i].className = dots[i].className.replace(" active", "");
    }

    dots[n-1].className += " active";
  }

  heroSlide(1);

var heroSlideControl = document.querySelectorAll(".dot");

    heroSlideControl.forEach(dot=>{
      dot.addEventListener('click',function(e){
        let control=e.target;
        let index=control.getAttribute("data-index");
        heroSlide(index);
      },false);
  })





  function showSlides(slides,n) {
      var i;
      n=Number(n);
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";  
    }
    slides[n-1].style.display = "block";  
  }






//click on images
function renderGallery(index){
    index=Number(index);
    
    //grab gallery modal
    let galleryModal=document.getElementById('gallery-modal');
    let previousActiveSlide=galleryModal.querySelector(`.gallery-photo.active`);
    let newActiveSlide=galleryModal.querySelector(`div[data-index="${index}"].gallery-photo`);
    galleryModal.classList.remove('d-none');
        if(newActiveSlide!==previousActiveSlide){
            previousActiveSlide.classList.remove('active');
            newActiveSlide.classList.add('active');
        }


        //setup prev and next slide
        let allgallerySlide=document.querySelectorAll('.gallery-photo');
        let nextIndex = index==allgallerySlide.length-1?0:index+1;
            document.querySelector(`div[data-index="${nextIndex}"].gallery-photo`).classList.add('next');
        let prevIndex = index==0? allgallerySlide.length-1:index-1;
            document.querySelector(`div[data-index="${prevIndex}"].gallery-photo`).classList.add('prev')

        //update the summary count view
        summaryView(index+1,allgallerySlide.length)
        
}
let allImg=document.querySelectorAll("#morePhotos img");
    allImg.forEach(img=>{
        img.addEventListener('click',function(e){
            let control=e.target;
            let index=control.getAttribute("data-index");
            renderGallery(index-1);
        },false);
    })


//prev and next

let allgallerySlide=document.querySelectorAll('.gallery-photo');
let prev=document.querySelector('.gallery .prev-btn')
let next=document.querySelector('.gallery .next-btn')

function gallerySlide(action){
    let active=document.querySelector('.gallery-photo.active');
    let next=document.querySelector(`.gallery-photo.${action}`);
        next.classList.remove(action);
    //get active
    active.classList.replace('active',action);


}

function summaryView(position,total){
   document.querySelector('.summary-view .current-position').innerHTML=position
    document.querySelector('.summary-view .total-position').innerHTML=total
}

function resetGallery(){

    let n= document.querySelector('.gallery-photo.next');
        n!=null?n.classList.remove('next'):"do nothing";

    let p= document.querySelector('.gallery-photo.prev')
        p!=null?(p.classList.remove('prev')):"do nothing";
}

function prevgallerySlide (){
        gallerySlide('next');
    let totalSlide=allgallerySlide.length;
    //get prev to add active
    let prev=document.querySelector('.gallery-photo.prev');
    let prevIndex= Number(prev.getAttribute('data-index'));
        summaryView(prevIndex+1,totalSlide)
        prev.classList.replace('prev','active');


    //apoint new prev
        prevIndex = prevIndex==0? totalSlide-1:prevIndex-1;
        let p=document.querySelector(`div[data-index="${prevIndex}"].gallery-photo`);
            p.classList.add('prev');
    }

function nextgallerySlide  (){
        gallerySlide('prev');
        let totalSlide=allgallerySlide.length;
        //get next to add active
        let next=document.querySelector('.gallery-photo.next');
        let nextIndex= Number(next.getAttribute('data-index'));
            summaryView(nextIndex+1,totalSlide);
            next.classList.replace('next','active');

            //appoint new next
            nextIndex = nextIndex==totalSlide-1?0:nextIndex+1;
            
            document.querySelector(`div[data-index="${nextIndex}"].gallery-photo`).classList.add('next');

    }

    prev.addEventListener('click',prevgallerySlide,false);
    next.addEventListener('click',nextgallerySlide,false);