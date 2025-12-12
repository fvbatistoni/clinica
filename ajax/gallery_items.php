<style type="text/css">

	.photo_holder{

		margin: 10px;

		float: left;

		text-align: center;

	}

	body{

		text-align: center;

	}

</style>



<?php

  require_once('dbconn.php');



   $gallery_id  = trim($_GET["id"]);



    $stmt = $dbconn->prepare("SELECT id,file_name

        FROM gallery_images

        WHERE gallery_id=:gallery_id");

    $stmt->bindParam(':gallery_id', $gallery_id);  

    $stmt->execute();

    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);



    for($i=0;$i<count($data);$i++){

		$end = explode("/",$data[$i]['file_name']);

                    echo "<div class='photo_holder'>";

                    echo "<a href='print_desenho.php?id=".$data[$i]['id']."'><img src='../uploads/images/" . $end[0].'/thumbs/'.$end[1] . "' style='max-height:220px;max-width:157px;'/></a>";

					echo "</div>";		

    }



    $dbconn = null;    