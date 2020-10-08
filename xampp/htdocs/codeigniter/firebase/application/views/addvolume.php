<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add volume</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <style>
        form{
            width:400px;
            height: 200px;
            margin: 50px  auto;
           
        }
        .wrapper{
            width:400px;
            height: 200px;
            margin: 0px  auto;
            display: flex;
            flex-direction: row;
            justify-content: center;

        }
        .counter-wrapper{
            width:400px;
            height: 100px;
            font-size: 30px;
            margin: 0px  auto;
        }
        button{
            width: 200px;
            height: 50px;
            margin-right: 20px;
            
        }
    </style>
</head>
<body>
    <div class="container">
    <h1 align="Center" style="color:green">Virtual IOT Deveice</h1>
   <form action="">
       <div class="form-group">
        <select name="resources_name" id="resources" class="form-control form-control-sm">
            <?php foreach($tanks as $tank){?>
                <option value="<?php echo  $tank['tank_id']; ?>"> <?php echo  $tank['tank_id'] ?></option>
                <?php
                     }
                     ?>
        </select> 
       </div>
   </form>
   <div class="counter-wrapper">
       <p id="counter"></p>
   </div>

   <div class="wrapper">
       <button id="fill-btn" class="btn btn-primary">Fill Start</button>
       <button id="stop-btn" class="btn btn-danger">Fill Stop</button>
   </div>
</div>
<script src="https://code.jquery.com/jquery-2.2.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.3/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.3/firebase-analytics.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.15.3/firebase-firestore.js"></script>

<script>
    var firebaseConfig = {
    apiKey: "AIzaSyBCPes0gI0ZJfXSBtwVHhTj53yVucWpWEo",
    authDomain: "nem-virtual.firebaseapp.com",
    databaseURL: "https://nem-virtual.firebaseio.com",
    projectId: "nem-virtual",
    storageBucket: "nem-virtual.appspot.com",
    messagingSenderId: "61621599602",
    appId: "1:61621599602:web:0f83df7c0cc0f7bfa571eb"
  };
            
    firebase.initializeApp(firebaseConfig);
           

      $(document).ready(function(){
       
          resources_id=$("#resources").val()
          console.log(resources_id)
          const db = firebase.firestore()
          const load_data=async()=>{
             let tank=db.collection("tanks").doc(resources_id)
             let doc= await tank.get()

             volume=doc.data().volume
             setData(volume)
            

           }
         load_data()
         function setData(volume){
         current_volume=volume;

         }
          
          
        
       $('#fill-btn').click(function(){
         resources_id= $('#resources').val();
          timer=setInterval(() => {
            performFill();
         },2000);
        
       })

       $('#stop-btn').click(function(){
          clearInterval(timer)
       })

       function performFill(){
          
          
          
            const db = firebase.firestore()
            db.collection("tanks").doc(resources_id).update({
            volume:current_volume,
           
            })
            .then(function() {
                $('#counter').html(current_volume)
                console.log("Document successfully written!");
                current_volume=100+current_volume;
            })
            .catch(function(error) {
                console.error("Error writing document: ", error);
            });
       }

    })
</script>

</body>
</html>