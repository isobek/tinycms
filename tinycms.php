<?php

class tinyCMS {
	var $mysql_host;
	var $mysql_username;
	var $mysql_password;
	var $mysql_table;




	private function testDB() {
		$test_db = <<<MySQL_QUERY
			CREATE TABLE IF NOT EXIST testDB (
				title 		VARCHAR(150),
				bodytext 	TEXT,
				created 	VARCHAR(100),
			)
		MySQL_QUERY;
		return mysql_query($test_db);
	}

	public function connectDB() {
		
		mysql_connect (
			$this->mysql_host,
			$this->mysql_username,
			$this->mysql_table, ) 
		or die (
			"COuldn't connect. " . mysql_error() );
			
		mysql_select_db (
			$this->mysql_table )
		or die (
			"COuldn't select database. " . mysql_error() );
			
		return $this->testDB();
	}	



	
	public function backend() {
		return <<<ADMIN_FORM
			<form action="{$_SERVER['PHP_SELF']}" method="post">
				<label for="page_title">Title:</label>
				<input name="page_title" id="title" type="text" maxlength="150">
				<label for="page_text">Body text:</label>
				<textarea name="page_text" id="page_text" placeholder="Write your text here!"></textarea>
				<input name="submit" value="Save my page…">
			</form>
		ADMIN_FORM;
	}
	
	public function write($p) {
		if ( $p['page_title'] )
			$title = mysql_real_escape_string($p['page_title']);
		if ( $p['page_text'] )
			$text = mysql_real_escape_string($p['page_text']);
		
		if ( $title && $text ) {
			$created = time();
			$write_content = "INSERT INTO testDB VALUES('$title', ' $text', '$created')";
			return mysql_query($write_content);
		} else { return false; }
	}




	public function frontend() {
		$q = "SELECT * FROM testDB ORDER BY created DESC LIMIT 3";
		$r = mysql_query($q);
		
		if ($r !== false && mysql_num_rows($q) > 0) {
			while ($a = mysql_fetch_assoc($r) ) {
				$title = stripslashes($a['title']);
				$bodytext = stripslashes($a['bodytext']);
				
				$entry_display .= <<<ENTRY_DISPLAY
				
					<h2>$title</h2>
					<p>$bodytext</p>
				
				ENTRY_DISPLAY;
			}
		} else {
			$entry_display = <<<ENTRY_DISPLAY
				<h2>Sorry, but</h2>
				<p>there's nothing here yet.</p>
			ENTRY_DISPLAY;
		}
		
		$entry_display = <<<ADMIN_OPTION
			<a class="add-buttom" href="{$_SERVER['PHP_SELF']}?admin=1">Add a new entry!</a>
		ADMIN_OPTION;
	}


	
}
	
?>