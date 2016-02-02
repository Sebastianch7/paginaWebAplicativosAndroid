<?php
    require('Data_connection.php');
	class Connection{
	  private $Data_connection;	
	  private $server="";
	  private $user="";
	  private $password="";
	  private $data_base="";
	  private $conexion;
	  
	  public  function __construct()
	  {	
	  	$this->Data_connection=new Dto_connection();
		$this->server=$this->Data_connection->HOST;
		$this->user=$this->Data_connection->USER;
		$this->password=$this->Data_connection->PASSWORD;
		$this->data_base=$this->Data_connection->DATA_BASE;
	  }
	   public  function connection()
	  {  
	   $conexion =  mysql_connect($this->server, $this->user, $this->password);
		if (!$conexion) {
			die('Could not connect: ' . mysql_error());
		}
		else{
		//echo 'Connected successfully';
		$bd_selection = mysql_select_db($this->data_base, $conexion);
			if (!$bd_selection) {
				die ('It cannot be used database : ' . mysql_error());
			}
		}
		
		
		return $conexion;
	  }
	  
		 public  function disconnect($con)
	  {
		
		if(mysql_close($con))
		{
			//echo "I was disconnected from the database ";
		}
		
	  }	 
	}	

?>