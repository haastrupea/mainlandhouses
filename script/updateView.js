
function getComponent(endpoint,callB,requestMethod="post"){
  let ajax= new XMLHttpRequest();
  
ajax.onreadystatechange=function(){
  if (this.readyState == 4 && this.status == 200) {
    callB(this.responseText);
  }
}

ajax.open(requestMethod,`${endpoint}`,true);
ajax.responseType = "";
ajax.send();
}

let callBack = (res) =>{
  //nothing
}

    let effectChange = (e) => {
      let target = e.target;
      let value = target.value;
        if(value==''){
          return;
        }
      let imgId = target.getAttribute("data-img-id");
      let endpoint= `/admin/gallery/updateView/${imgId}/${value}/ajax`;

          getComponent(endpoint,callBack);

  }

  let options= document.querySelectorAll('.select-view');
      // options.addEventListener('change',effectChange,false);

