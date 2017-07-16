<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
  $id = $_GET['id'];
  $hid = fetchinfo("hid","cflobbies","id",$id);
  $cid = fetchinfo("cid","cflobbies","id",$id);
  $winner = fetchinfo("win","cflobbies","id",$id);
  $wageamount = fetchinfo("value","cflobbies","id",$id);
  $hname = fetchinfo("name","users","steamid",$hid);
  $himage = fetchinfo("avatar","users","steamid",$hid);
  $cimage = fetchinfo("avatar","users","steamid",$cid);
  $side = fetchinfo("hside","cflobbies","id",$id);
  $status = fetchinfo("ended","cflobbies","id",$id);

  /*
  echo "ID = $id <br>";
  echo "name = $hname <br>";
  echo "Host image = $himage <br>";
  echo "Wage Amount = $wageamount <br>";

*/


?>



<div class="col-md-12" id="gameValid">

<h1 class="page-header">
Duel
</h1>
</div>
<div class="container-fluid">
    <div class="row">
      <div class="col-md-4 text-center">
<?php
            if($side == 1){$sidetext ='<img src="images/ct-coin.png" width="50" class="duelicon">';}else{$sidetext = '<img src="images/t-coin.png" width="50" class="duelicon">';}
            echo "<br>$sidetext";
            ?>
            <br>
            <?php
             echo '<h3><img src="'.$himage.'" class="img-circle" width="120"><h3>';
            ?>

</div>

          <div class="col-md-4" align="center">
            <h3> Flipping... </h3>
            <br>
            <h3> VS </h3>
            <br>
            <br>

            <?php
             if($status == 1 ||  $status == 2){
            if($winner == 1){
            echo '<script>
                 var count=4;
                 var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
                   function timer()
                   {
                     count=count-1;
                      if (count <= -1)
                        {
                       clearInterval(counter);
                       document.getElementById("countdown").innerHTML = "<img src=\"images/ctflip.gif\" width=\"200\">";
                       refreshCredits();
                           return;
                            }

                         document.getElementById("countdown").innerHTML = count;
                          //Do code for showing the number of seconds here

                             }
                 </script>';
                 payout();
                }

                if($winner == 2){
                echo '<script>
                     var count=4;
                     var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
                       function timer()
                       {
                         count=count-1;
                          if (count <= -1)
                            {
                           clearInterval(counter);
                           document.getElementById("countdown").innerHTML = "<img src=\"images/tflip.gif\" width=\"200\">";
                           refreshCredits();
                               return;
                                }

                             document.getElementById("countdown").innerHTML = count;
                              //Do code for showing the number of seconds here

                                 }
                     </script>';
                     payout();
                    }

                 }


                  function payout() {
                    $id = $_GET['id'];
                    $wageamount = fetchinfo("value","cflobbies","id",$id);
                    $status = fetchinfo("ended","cflobbies","id",$id);
                    $hid = fetchinfo("hid","cflobbies","id",$id);
                    $cid = fetchinfo("cid","cflobbies","id",$id);
                    $side = fetchinfo("hside","cflobbies","id",$id);
                    $winner = fetchinfo("win","cflobbies","id",$id);

                    $balh = fetchinfo("credits","users","steamid",$hid);
                    $balc = fetchinfo("credits","users","steamid",$cid);

                    if($status == 1){
                        $cut = (($wageamount *2) /100) * 5;
                        $payoutamount = ($wageamount *2) - $cut;

                        if($side == $winner){
                          $updatedbal = $balh + $payoutamount;
                          mysql_query("UPDATE users SET `credits`='$updatedbal' WHERE `steamid`='$hid'");

                        }else if($side != $winner){
                           $updatedbal = $balc + $payoutamount;
                          mysql_query("UPDATE users SET `credits`='$updatedbal' WHERE `steamid`='$cid'");

                        }

                        mysql_query("UPDATE cflobbies SET `ended`='2' WHERE `id`='$id'");


                  }



                  }

                ?>



                 <h3 id="countdown">Flipping..</h3>
             </div>
             <div class="col-md-4 text-center">
            <?php
            $cside;
             if($side == 2){$cside ='<img src="images/ct-coin.png" width="50" class="duelicon2" style="float: left">';}else{$cside = '<img src="images/t-coin.png" width="50" class="duelicon2" align="left">';}
             echo "<br>$cside";
             ?>
             <br>
             <?php
             if($status == 0){
               echo '<h3><img src="images/def.jpg" class="img-circle" width="120"><h3>';
             }else{
               echo '<h3><img src="'.$cimage.'" class="img-circle" width="120"><h3>';

             }
             ?>


          </div>

        </div>


          <div class="col-md-3 col-md-offset-5">
          <div class="col-md-4">



              </div>
              <div class="col-md-5" align="center">
                <div class="col-md-12 text-center">

              <!-- Form shit -->
              </center>
</span>
            </div></div>
         <!-- Counter -->

</div>

<div class="col-md-12 text-center">
<br>
<br>
<?php
if($status == 0){
echo '
<button type="button" onClick="join()" name="join" value="join" class="btn btn-back">Join '.$wageamount.'</div></button>
<br>
';
}else{
echo '<h4>Game Over</h4>';
}
?>
<?php if($_SESSION['steamid'] !=""){ ?>
   <script>
 function join() {
 $.ajax({
   type:"post",
   url: "updatejoin.php?id=<?php echo $id; ?>",
   data: {},
   success: function(data){
   }
 });
 updatelobby();
 refreshCredits();
 }
 </script>
 <?php } ?>

<br><br>
<br><br>


<a href="coinflip.php" class="btn btn-back"><i class="fa fa-arrow-left"></i> Go back</a>
</div>

</div>


              </div>

            </div>
        </div>

    </div>


</div>
          </div>
      </div>
