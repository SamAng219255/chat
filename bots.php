<?php
function callbot($botid,$botargs,$conn) {
  $botdataquery="SELECT * FROM `chat`.`bots` WHERE `id`=".$botid.";";
  $botdataqueryresultrow=mysqli_fetch_row(mysqli_query($conn,$botdataquery));
  $bottype=$botdataqueryresultrow[1];
  $botroom=$botdataqueryresultrow[2];
  $botdata=$botdataqueryresultrow[3];
  $botcreated=$botdataqueryresultrow[4];
  //echo 'Bot called with id: '.$botid.' and type: '.$bottype.' in room: '.$botroom.' with data: '.$botdata.'.';
  if($bottype=="dice") {
    $temp="die";
    if($botargs[0]>1) {
      $temp="dice";
    }
    echo '<p>You roll '.$botargs[0].' '.$botargs[1].'-sided '.$temp.'.</p>';
    $outstr=$botargs[0]."d".$botargs[1].": ";
    $totalroll=0;
    for($i=0; $i<$botargs[0]; $i++) {
      $dieresult=rand(1,$botargs[1]);
      $outstr.=$dieresult;
      $totalroll+=$dieresult;
      $outstr.=",";
    }
    $outstr.=" total: ".$totalroll.".";
  }
  else {
    echo "<p>Unknown bot type.</p>";
  }
  if(isset($outstr)) {
    $sql="INSERT INTO `chat`.`privchatroom` (`id`, `username`, `content`, `room`) VALUES (0,'bot_".$botid."','".$outstr."','".$botroom."')";
    mysqli_query($conn,$sql);
  }
}
?>
