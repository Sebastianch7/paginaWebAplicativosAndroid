<?php
	require ('Connection.php');

	class Consult{

		private $sql = "";
		private $user = "";
		private $password = "";
		private $resultado = "";
		private $mysql = "";
		private $con = "";

		public function __construct($user,$password)
		{
			
			$this->sql="";
			$this->usuario =  $user;
			$this->password = $password;
			$this->resultado = "";			
		}

		public function searchUser()
		{
			$con = new Connection();
			$mysql = $con->connection();
			$this->sql = 
				"SELECT
				usuarios.id as usu,
				aplicativo.id as app
				FROM usuarios,aplicativo
				WHERE
				usuarios.usuario = '".$this->usuario."'
				AND
				aplicativo.password = '".$this->password."'";

				$resultado = mysql_query($this->sql);
				$fila = mysql_fetch_array($resultado);
				$con->disconnect($mysql);
				return $fila;
		}


	function descargaApk($array)
	{
		try
		{
			if($array != NULL)
			{

				$con = new Connection();
				$mysql = $con->connection();
				$this->sql = 
				"SELECT
				aplicativo.ubicacion
				FROM usuarios
				INNER JOIN permisos on permisos.idUsuario = usuarios.id
				INNER JOIN aplicativo on aplicativo.id = permisos.idAplicativo
				where
				usuarios.id = ".$array['usu']."
				and
				aplicativo.id = ".$array['app']."
				and permisos.estado = 0";
				$resultado = mysql_query($this->sql);
				$fila = mysql_fetch_array($resultado);
				$con->disconnect($mysql);
			
			}
			else
			{
				$fila = $array;
			}


		
		}
		catch(Exception $e)
		{

			 echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		return $fila;
	}	

	}
	$usuario = $_POST['data_usuario'];
	$password = $_POST['data_password'];
	$respuesta = null;
	if($usuario && !empty($password)) 
	{
		$obj_consult = null;
	    $action = $_POST['action'];
	    if($action == 'searchUser')
	    {
	    	$obj_consult = new Consult($usuario,$password);
	    	$row = $obj_consult->searchUser();
	    	
	    	if(count($row) > 0)
	    	{
	    		$row2 =	$obj_consult->descargaApk($row);
	    		
	    		if($row2)
	    		{
	    			$respuesta = $row2[0];
	    		}
	    		else
	    		{
	    			$respuesta = '';
	    		}
	    	}
	    	else
	    	{
	    		$respuesta = '';
	    	}

	    	echo $respuesta;
	    }
	}
?>