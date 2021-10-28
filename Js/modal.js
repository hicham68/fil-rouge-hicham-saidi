// Get the modal
function changeModalStatut(id){

  var modal = document.getElementById( `myModal${id}`);

  // Get the <span> element that closes the modal
  var span = document.getElementById(`close${id}`);

  // When the user clicks on the button, open the modal
  
  modal.style.display = "block";
  

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
      // Code ajax 

    }
  }
  console.log('bouton ' + id+ " cliqué")
  getApi(id)

}




function getApi(id) { 

  fetch("http://localhost/fil_rouge_hicham_saidi/api/single_read.php?id=" + id)
       .then(function(reponse){
           return reponse.json()
       })
       .then(function(data){
        console.log(data)

        let html =  `<h1> Coach :</h1> 
            <h2> ${data.name}:</h2> 
            <p> <strong> age :  ${data.age} ans </strong></p> `

        document.querySelector("#coach"+ id).innerHTML = html;

       })
}
