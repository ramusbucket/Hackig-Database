<?php
$conn = new mysqli("", "", "", "");
$conn->set_charset("utf8");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT Id FROM knx";
$result = $conn->query($sql);
$count = mysqli_num_rows($result);
if(!isset($_POST['cerca'])){
$stmt = $conn->prepare("SELECT data, descrizione, comando, Categoria FROM knx ORDER BY RAND() LIMIT 5");
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($data, $descrizione, $comando, $Categoria);

}else{
$val = $_POST['cerca'];
$stmt = $conn->prepare("SELECT data, descrizione, comando, Categoria FROM knx WHERE descrizione LIKE CONCAT('%', ?, '%') or comando LIKE CONCAT ('%', ?, '%')");
$stmt->bind_param('ss', $val, $val);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($data, $descrizione, $comando, $Categoria);
if(isset($_POST['cli'])){
	while($stmt->fetch()){
		$cmdd = htmlspecialchars($comando);
		echo "\033[92m$descrizione\n";
		echo "\033[0m$cmdd\n\n";
	}
$stmt->close();
$conn->close();
exit();	
}
}

include('header.html');

?>


     <div class="row">
        <div class="col-sm-10 col-sm-offset-1">
            <div id="imaginary_container"> 
	       <form action="" method="POST">
                <div class="input-group stylish-input-group">
                    <input type="text" class="form-control"  placeholder="Search" name="cerca">
                    <span class="input-group-addon">
                        <button type="submit">
                            <span class="glyphicon glyphicon-search"></span>
                        </button> 
                    </span>
                 </div>
                </form>
             </div>
         </div>
	 <div class="col-sm-2 pull-right number">
	 </div>
      </div>
</div>

<br>

<?php

echo '<br><br><div class="container"><table class="table table-hover"><thead><tr><th width="15%">Data dded</th><th width="40%">Description</th><th width="15%">Category</th><th width="15%">Commands <span id="number"></span></th><th width="15%">Clipboard</th></tr></thead><tbody>';

$i = 1;  
while($stmt->fetch()){
	$cmdd = htmlspecialchars($comando);
    $b64cmd = base64_encode($cmdd);
	echo "<tr><td>$data</td><td>$descrizione</td><td>$Categoria</td>
    <td><button type='button' class='btn btn-info' data-toggle='collapse' data-target='#demo$i'>Command</button></td>
    <td><button type='button' class='btn btn-info js-tooltip js-copy' data-toggle='tooltip' data-placement='bottom' data-copy='$b64cmd' >Copy</button></td></tr>
    <tr><td colspan='5'><div id='demo$i' class='collapse prettyprint linenums'><pre><code>$cmdd</code></pre></div></td></tr>";
    ++$i;
} 
echo "</tbody></table></div>";
$stmt->close();
$conn->close();

include('footer.html');

?>

