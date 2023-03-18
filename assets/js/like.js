
const hearts = document.querySelectorAll('.like')




hearts.forEach(item => {
    item.addEventListener('click', function(){
       
        let noeud = item.childNodes[0]
        
        if(item.getAttribute('unlike')){
            alert('Vous devez être connectés sur le site pour pouvoir liker les patterns')
        }else{
             // Activer ou non le like (rempli le coeur)
            if(noeud.getAttribute('like')=="true"){
                console.log('unlike')
                noeud.classList.add('fa-regular')
                noeud.classList.remove('fa-solid')
                noeud.setAttribute('like', 'false')
            }else{
                console.log('like')
                noeud.classList.add('fa-solid')
                noeud.classList.remove('fa-regular')
                noeud.setAttribute('like', 'true')
            }
        }
       
       
    })
});