                        <?php
						@include_once('link.php');
						@include_once('steamauth/steamauth.php');

						echo '<table class="table" style="width:80%;">

								<thead>
									   <tr>
										   <th>Name</th>
										   <th>Status</th>
										   <th>Waged</th>
										   <th>Side</th>
									   </tr>
									 </thead>';
                        $rs = mysql_query("SELECT * FROM `cflobbies` WHERE `ended`='0' ORDER BY `value` DESC");
                        while($row = mysql_fetch_array($rs))
                        {
                          $id = $row['id'];
                          $hid = $row['hid'];
                          $hname = fetchinfo("name","users","steamid",$hid);
                          $himage = fetchinfo("avatar","users","steamid",$hid);
                          $wageamount = fetchinfo("value","cflobbies","id",$id);
                          $side = fetchinfo("hside","cflobbies","id",$id);
                          $status = fetchinfo("ended","cflobbies","id",$id);


                          $sidetext;
                          $status;

                          if($status == 0){$status = 'Joinable';}else{$status = 'Ended';}
                          if($side == 1){$sidetext ='<img src="images/ct-coin.png" width="25">';}else{$sidetext = '<img src="images/t-coin.png" width="25">';}
                          echo '

                            <tbody>
                            <td><img src="'.$himage.'" class="img-circle" width="25"> '.$hname.'</td>
                            <td><a href="lobby.php?id='.$id.'">'.$status.'</td>
                            <td>'.$wageamount.'</td>
                            <td>'.$sidetext.'</td>
                            ';
                        }
						echo '       </tbody>
                                            </table>';
                        ?>
