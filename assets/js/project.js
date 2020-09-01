$(function() {
  let element = document.getElementById("container-loader");
  element.classList.add("invisible");

  const btnEdit = document.getElementsByClassName("edit-project");
  for (let i = 0; i < btnEdit.length; i++) {
    btnEdit[i].addEventListener("click", openModal);
  }

  const btnRemove = document.getElementsByClassName("remove-project");
  for (let i = 0; i < btnRemove.length; i++) {
    btnRemove[i].addEventListener("click", removeProject);
  }

  document.getElementById("save").addEventListener("click", saveProject);


  function openModal(){
    const idProject = this.getAttribute("data-id");
    const labelProject = this.getAttribute("data-label");
    const url = "/projet/"+idProject+"/edition";

    $("#modal-edit").modal("show");

    $.ajax( url)
      .done(function(result) {
        let titre = 'Edition du projet ' + labelProject;
        if(labelProject === ""){
          titre = "Ajouter un projet"
        }
        document.getElementById("modal-edit-label").text = titre;
        document.getElementById("modal-body").innerHTML =result;
      })
  }

  function saveProject(){
    let element = document.getElementById("container-loader");
    element.classList.toggle("invisible");
    document.getElementsByName("project")[0].submit();
  }

  function removeProject(){
    const idProject = this.getAttribute("data-id");
    const url = "/projet/"+idProject+"/suppression";

    let element = document.getElementById("container-loader");
    element.classList.toggle("invisible");

    $.ajax({
      url: url,
      type: 'DELETE',
      success: function(result) {
        if(result){
          document.getElementById("row-"+idProject).remove();
          let element = document.getElementById("container-loader");
          element.classList.toggle("invisible");
        }
      }
    })
  }

});



