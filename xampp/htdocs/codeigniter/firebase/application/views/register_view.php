<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tank registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

    <style>
      body{
          padding:30px;
      }
    </style>
</head>
<body>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
 Add +
</button>
<a href="<?php base_url() ?>register/updatedata">Add volume</a>
<div id="message"></div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="form" action="<?php echo base_url() ?>register/store" method="POST">
      <div class="modal-body">
        <div class="form-group">
       <label for="">Resources Id</label>
       <input id="resources_id" type="text" name="resources_id" class="form-control" placeholder="Resources Id">
    </div> 
    <div class="form-group">
    <select name="resources_name" id="resources" class="form-control form-control-sm">
        <option value="tank">Tank</option>
        <option value="bowser">Bowser</option>
        <option value="bowser">Barrel</option>
    </select> 
    </div>
    <div class="form-group">
    <select name="loaction_id" class="form-control form-control-sm">
      
         <?php foreach($project_codes as $project_code){?>
          <option value="<?php echo  $project_code['location_code']; ?>"> <?php echo  $project_code['location_code'] ?></option>
          <?php
               }
               ?>
    </select> 
    </div>
    <div class="form-group">
    <label for="">Capacity</label>
       <input id="capacity" name="capacity" type="number" class="form-control" placeholder="Capacity" >
    </div>

    </div>
       
     
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button id="submit" type="sumbit" class="btn btn-primary">Send</button>
      </div>
      </form>
    </div>
  </div>
</div>
    
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.3/firebase-app.js"></script>

<script src="https://www.gstatic.com/firebasejs/7.15.3/firebase-firestore.js"></script>


<script>
    $(document).ready(function(){
       var resources=$('#resources')
       resources.change(function(){
           if(resources.val()=='bowser' || resources.val()=='barrel'){
              $('#capacity').attr('disabled',true)
           }
           else{
            $('#capacity').attr('disabled',false)
           }
       })

      $('#form').on('submit',function(e){
        e.preventDefault()
        resourcesId=$('#resources_id').val()
        capacity=$('#capacity').val()
        var form=$(this)
        $.ajax({
          url:form.attr('action'),
          data:form.serialize(),
          type:form.attr('method'),
          dataType:'json',
          success:function(response){
            if(response.success==true){
              if(resources.val()=="tank"){
                perforFirebase()
               
                

              }
             
               $('#message').html(response.message)
               $('#form')[0].reset()
              
            }
            else{
              if(response.message instanceof Object){
               
                 if($('p').length>0){
                   $('p').remove()
                 }
                
                 $.each(response.message,function(index,value){
                   
                   id=$('#'+index)
                   id
                      .closest('.form-group')
                      .removeClass('has-error')
                      .removeClass('has-success')
                      .addClass(value.length > 0 ? 'has-error' : 'has-success')
                      .after(value);
                 })
              }
            }
          }
          
        })
        
      })
      
     function perforFirebase(){
      var firebaseConfig = {
    apiKey: "AIzaSyBCPes0gI0ZJfXSBtwVHhTj53yVucWpWEo",
    authDomain: "nem-virtual.firebaseapp.com",
    databaseURL: "https://nem-virtual.firebaseio.com",
    projectId: "nem-virtual",
    storageBucket: "nem-virtual.appspot.com",
    messagingSenderId: "61621599602",
    appId: "1:61621599602:web:0f83df7c0cc0f7bfa571eb"
  };
  // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
       
        const db = firebase.firestore()
     db.collection("tanks").doc(resourcesId).set({
    capacity:capacity,
    volume:0,
   
})
.then(function() {
    console.log("Document successfully written!");
})
.catch(function(error) {
    console.error("Error writing document: ", error);
});
            
     }
     


      
    })
</script>
</body>
</html>