<?php
    Class db{
        private $host = 'localhost';
        private $usuario = 'root';
        private $password = '';
        private $base = 'misclientes';

        //conectar a la BD misclientes
        public function conectar(){
            $conexion_mysql = "mysql:host=$this->host;dbname=$this->base";
            $conexionBD = new PDO($conexion_mysql, $this->usuario, $this->password);
            $conexionBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //cuando creas la BD con codificacion latin1_swedish_ci pero si usas utf-8 spanish2
            //esta linea_arregla la codificacion de caracteres <utf-8></utf-8>
            $conexionBD -> exec("set names utf8");

            return $conexionBD;
        }

    }
?>