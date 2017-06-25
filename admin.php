<?php
include 'db_connect.php';
include 'functions.php';
sec_session_start();

include('header3.html');

if(isset($_GET['error'])) { 
   echo '<div class="alert alert-danger"><strong>ACCESS DENIED!</strong> Wrong Username or password.</div>';
}

if(login_check($mysqli) == true) {

if(isset($_POST['descrizione'], $_POST['command'])){
   if ($insert_stmt = $mysqli->prepare("INSERT INTO knx (descrizione, comando) VALUES (?, ?)")) {    
   $insert_stmt->bind_param('ss', $_POST['descrizione'], $_POST['command']); 
   // Esegui la query ottenuta.
   $insert_stmt->execute();
   echo '<br><br><div class="alert alert-success"><strong>SUCCESS</strong> Command successfull added. </div>';
}else{
	echo '<br><br><div class="alert alert-danger"><strong>ERROR!</strong> Insert command in database was failed. </div>';
}
}

if(isset($_POST['p'])){
$username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $_POST['username']); // ci proteggiamo da un attacco XSS
// Recupero la password criptata dal form di inserimento.
$password = $_POST['p']; 
// Crea una chiave casuale
$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
// Crea una password usando la chiave appena creata.
$password = hash('sha512', $password.$random_salt);
// Inserisci a questo punto il codice SQL per eseguire la INSERT nel tuo database
// Assicurati di usare statement SQL 'prepared'.
if ($insert_stmt = $mysqli->prepare("INSERT INTO members (username, password, salt) VALUES (?, ?, ?)")){ 
	$insert_stmt->bind_param('sss', $username, $password, $random_salt); 
	// Esegui la query ottenuta.
	$insert_stmt->execute();
	echo '<br><br><div class="alert alert-success"><strong>SUCCESS</strong> User successfull added. </div>';
}else{
	echo '<br><br><div class="alert alert-danger"><strong>ERROR!</strong> Insert user in database was failed. </div>';
}
}


?>

<ul class="nav nav-tabs">
  <li class="active"><a data-toggle="tab" href="#Command">New Command</a></li>
  <li><a data-toggle="tab" href="#User">New User</a></li>
  <li><a data-toggle="tab" href="#Log">Log Analysis</a></li>
</ul>


<div class="tab-content">
  <div id="User" class="tab-pane fade">
	<div class="container-fluid"> 
		<h3>Insert New User</h3>
		<form action="" method="post" name="login_form">
    			<div class="form-group">
		    	    <label for="username">Username:</label>
		            <input id="username" type="text" class="form-control" name="username" placeholder="Username">
		        </div>
    			<div class="form-group">
			     <label for="password">Password:</label>
		             <input id="password" type="password" class="form-control" name="password" placeholder="Password">
		        </div>
    			<div class="form-group"> 
		 	     <input type="button" class="btn btn-default" value="Create" onclick="formhash(this.form, this.form.password);" />
	 	        </div>
		</form>
	</div>
 </div>

 <div id="Command" class="tab-pane fade in active">
 	<div class="container-fluid"> 
		<h3>Insert New Command</h3>
		<form action="" method="POST">
    			<div class="form-group">
      				<label for="descrizione">Descrizione:</label>
      				<input type="text" class="form-control" id="descrizione" name="descrizione">
    			</div>
    			<div class="form-group">
  	  			<label for="command">Command:</label>
      				<textarea class="form-control" rows="12" id="command" name="command"></textarea>
    			</div>
    			<button type="submit" class="btn btn-default">Submit</button>
		</form>
	</div>
 </div>

 <div id="Log" class="tab-pane fade">
 	<div class="container-fluid"> 
		<h3>Log Analysis</h3>
		<div class="container"><table class="table table-hover"><thead><tr><th width="15%">Id</th><th width="40%">User_id</th><th width="15%">Data</th></tr></thead><tbody>
		<?php
		$query = "SELECT id, user_id, from_unixtime(time, '%D %M %Y %h:%i:%s') FROM log";
		$result = $mysqli->query($query);
			while($row = $result->fetch_array()){
				echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
		}			
		?>
		</tbody></table></div>
	</div>
</div>
<br><br>

<?php
} else {
?>

<form class="form-horizontal" action="process_login.php" method="post" name="login_form">
    <div class="form-group">
      <label class="control-label col-sm-2" for="username">Username:</label>
      <div class="col-sm-10">
      <input id="username" type="text" class="form-control" name="username" placeholder="Username">
    </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-2" for="password">Password:</label>
      <div class="col-sm-10">
      <input id="password" type="password" class="form-control" name="p" placeholder="Password">
    </div>
    </div>
    <br>
    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <input type="button" class="btn btn-default" value="Login" onclick="formhash(this.form, this.form.password);" />
      </div>
    </div>
  </form>
  <br>


<?php
}
include('footer.html');
?>
