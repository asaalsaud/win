<?php 
include './inc/db.php';
include './inc/form.php';

$sql = 'SELECT * FROM users ORDER BY RAND() LIMIT 1';
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

include './inc/db_close.php';
?>
<style>
    #countdown{
        color: #8f8fc6;
        padding: 10px;
    }
    #loader{
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    }

    .loader-con{
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
    background-color: #000000c4;
    }

    .list-group-item{
        background: transparent;
    }
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<body>

   

        <div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center bg-light">
            <div class="col-md-5 p-lg-5 mx-auto">
            <h1 class="display-4 fw-normal">Win with me</h1>
            <p class="lead fw-normal">Time remaining to close registration</p>
            <h3 id= "countdown"></h3>
            <p class="lead fw-normal">for the draw to win a free copy of our program.</p>
            </div>

            <div class="container">
            <h3>To enter the draw, follow the following steps: </h3>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Follow the live broadcast on my Facebook page on the date mentioned above</li>
                    <li class="list-group-item">I will be doing an hour-long live broadcast of free Q&A for everyone</li>
                    <li class="list-group-item">During the hour period, the registration page will open here, where you will register your name</li>
                    <li class="list-group-item">At the end of the live one name from the database will be randomly tested</li>
                    <li class="list-group-item">The winner will receive a free copy from our program</li>
                </ul>
            </div>
        </div>

       <div class="container">
       <div class="position-relative text-center">
            <div class="col-md-5 p-lg-5 mx-auto my-5">
       <form action="<?php $_SERVER['PHP_SELF'] ?>" method= "POST">
        <h3>Please enter your informations</h3>
        
            <div class="mb-3">
                <label for="firstName" class="form-label">First name</label>
                <input type="text" name="firstName" class="form-control" id="firstName" value = "<?php echo $firstName?>">
                <div  class="form-text error"><?php echo $errors['firstNameError'] ?></div>
            </div>
 
            <div class="mb-3">
                <label for="lastName" class="form-label">Last name</label>
                <input type="text" name="lastName"  class="form-control" id="lastName" value = "<?php echo $lastName ?>">
                <div  class="form-text error"><?php echo $errors['lastNameError'] ?></div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="text" name="email" class="form-control" id="email" value = "<?php echo $email ?>">
                <div  class="form-text error"><?php echo $errors['emailError'] ?></div>
            </div>
            
           <button type="submit"  name="submit" class="btn btn-primary">Submit</button>  
        </form>
        </div>
        </div>
    
        <!---- modal ---->
        <div class="loader-con">
            <div id="loader">
	            <canvas id="circularLoader" width="200" height="200"></canvas>
            </div>
       </div>

        <!-- Button trigger modal -->
        <div class= "d-grid gap-2 col-6 mx-auto my-5">
            <button type="button" class="btn btn-primary" id="winner">
             Choose The Winner
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">THE WINNER</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php foreach($users as $user):?>
                    <h1 class=" display-3 text-center modal-title" id="modalLabel"><?php echo htmlspecialchars($user['firstName']) .' '.htmlspecialchars($user['lastName']); ?></h1>
                    <?php endforeach; ?>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./js/bootstrap.bundle.min.js"></script>
    <script>
        var countDownDate = new Date("Nov 5, 2023 18:47:00").getTime();

        var x = setInterval(function() {
        var counter = document.querySelector("#countdown");
        var now = new Date().getTime();

        var distance = countDownDate - now;

        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        counter.innerHTML = days + "d " + hours + "h "
        + minutes + "m " + seconds + "s ";

        if (distance < 0) {
            clearInterval(x);
            counter.innerHTML = "You're late ):";
        }
        }, 1000);

        //choose winner program code
        const winner = document.querySelector("#winner");
        const loader = document.querySelector(".loader-con");
        
       

        var myModal = new bootstrap.Modal(document.getElementById('modal'), {
            keyboard: false
        })
   
        winner.addEventListener('click', function(){
            loader.style.display = 'block';

            setTimeout(function(){
                myModal.show();
            },3000);
        });

        var ctx = document.getElementById('circularLoader').getContext('2d');
        var al = 0;
        var start = 4.72;
        var cw = ctx.canvas.width;
        var ch = ctx.canvas.height; 
        var diff;
        var Sim;

        function progressSim(){
            diff = ((al / 100) * Math.PI*2*10).toFixed(2);
            ctx.clearRect(0, 0, cw, ch);
            ctx.lineWidth = 17;
            ctx.fillStyle = "#4285f4";
            ctx.strokeStyle = "#4285f4";
            ctx.textAlign = "center";
            ctx.font="28px monospace";
            ctx.fillText(al + '%', cw*.52, ch * .5 + 5, cw + 12);
            ctx.beginPath();
            ctx.arc(100, 100, 75, start, diff / 10 + start, false);
            ctx.stroke();
            if(al >= 100){
                clearTimeout(sim);
    
            }
            al++;
        }
        var sim = setInterval(progressSim, 40);
        
      
    </script>
</body>
</html>