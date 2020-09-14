$(function() {
  let element = document.getElementById("container-loader");
  element.classList.toggle("invisible");

  const btnEdit = document.getElementsByClassName("edit-tasks");
  for (let i = 0; i < btnEdit.length; i++) {
    btnEdit[i].addEventListener("click", openModal);
  }

  const btnRemove = document.getElementsByClassName("remove-tasks");
  for (let i = 0; i < btnRemove.length; i++) {
    btnRemove[i].addEventListener("click", removeTask);
  }

  document.getElementById("save").addEventListener("click", saveTask);


  function openModal(){
    const idTasks = this.getAttribute("data-id");
    const labelTask = this.getAttribute("data-label");
    const url = "/tâches/"+idTasks+"/edition";

    $("#modal-edit").modal("show");

    $.ajax( url)
      .done(function(result) {
        let titre = 'Edition du projet ' + labelTasks;
        if(labelTasks === ""){
          titre = "Ajouter un projet"
        }
        document.getElementById("modal-edit-label").text = titre;
        document.getElementById("modal-body").innerHTML =result;
      })
  }

  function saveTask(){
    let element = document.getElementById("container-loader");
    element.classList.toggle("invisible");
    document.getElementsByName("tasks")[0].submit();
  }

  function removeTask(){
    const idTasks = this.getAttribute("data-id");
    const url = "/tasks/"+idTasks+"/suppression";

    let element = document.getElementById("container-loader");
    element.classList.toggle("invisible");

    $.ajax({
      url: url,
      type: 'DELETE',
      success: function(result) {
        if(result){
          document.getElementById("row-"+idTasks).remove();
          let element = document.getElementById("container-loader");
          element.classList.toggle("invisible");
        }
      }
    })
  }

});
