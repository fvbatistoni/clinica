<style>
  @media print {
  body * {
    visibility: hidden;
  }
  #printable, #printable * {
    visibility: visible;
  }
  #printable {
  display: inline;
  width: 95%;
  height: auto;
  }
}
</style>

<p align="center">
<a href="javascript:window.print()"><img src="../images/printer.png" alt="Imprimir este desenho" border="0" id="remove"></a>

<?php
  require_once('dbconn.php');

   $id  = trim($_GET["id"]);

    $stmt = $dbconn->prepare("SELECT file_name
        FROM gallery_images
        WHERE id=:id");
    $stmt->bindParam(':id', $id);  
    $stmt->execute();
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    echo "<br><img src='../uploads/images/" . $data['file_name'] . "' alt=\"Desenho para imprimir !\" width=\"567\" height=\"794\" id=\"printable\"/>";

    $dbconn = null;    