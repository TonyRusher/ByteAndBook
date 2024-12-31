<?php
class Usuario {
	private $id;
	private $nombre;
	private $apellido1;
	private $apellido2;
	private $correo;
	private $contrasena;
	private $telefono;
	private $tipo;
	
	
	public function __construct($id, $nombre, $apellido1, $apellido2, $correo, $contrasena, $telefono, $tipo){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->apellido1 = $apellido1;
		$this->apellido2 = $apellido2;
		$this->correo = $correo;
		$this->contrasena = $contrasena;
		$this->telefono = $telefono;
		$this->tipo = $tipo;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function getNombreCompleto(){
		return $this->nombre." ".$this->apellido1." ".$this->apellido2;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getApellido1(){
		return $this->apellido1;
	}
	
	public function getApellido2(){
		return $this->apellido2;
	}
	
	public function getCorreo(){
		return $this->correo;
	}
	
	public function getContrasena(){
		return $this->contrasena;
	}
	
	public function getTelefono(){
		return $this->telefono;
	}
	
	public function getTipo(){
		return $this->tipo;
	}
	
	
	
	
	
}

class Direccion{
	private $calle;
	private $numeroExt;
	private $numeroInt;
	private $colonia;
	private $alcaldia;
	private $codigoPostal;
	
	
	public function __construct($calle, $numeroExt, $numeroInt, $colonia, $alcaldia, $codigoPostal,){
		$this->calle = $calle;
		$this->numeroExt = $numeroExt;
		$this->numeroInt = $numeroInt;
		$this->colonia = $colonia;
		$this->alcaldia = $alcaldia;
		$this->codigoPostal = $codigoPostal;
	}
}

?>