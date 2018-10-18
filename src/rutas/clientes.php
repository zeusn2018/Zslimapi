<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

//Obtener todos los clientes
$app->get('/api/clientes', function(Request $request, Response $response){

    $consulta = 'SELECT * FROM clientes';

    try{
        //instanciacion base de datos
        $db = new db();

        //conexion
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $clientes = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;        
        
        //Exportar y mostrar en JSON todos los clientes
        echo json_encode($clientes);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }



});

//Obtener un cliente segun su id
$app->get('/api/clientes/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    $consulta = "SELECT * FROM clientes where id = '$id'";

    try{
        //instanciacion base de datos
        $db = new db();

        //conexion
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $cliente = $ejecutar->fetchAll(PDO::FETCH_OBJ);
        $db = null;        
        
        //Exportar y mostrar en JSON de un cliente
        echo json_encode($cliente);

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

//Agregar un cliente sin id asi nomas
$app->post('/api/clientes/agregar', function(Request $request, Response $response){

    //$id = $request->getAttribute('id');
    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');
    $departamento = $request->getParam('departamento');

    $consulta = "INSERT INTO clientes (nombre, apellidos, telefono, email, direccion, ciudad, departamento) VALUES 
    (:nombre, :apellidos, :telefono, :email, :direccion, :ciudad, :departamento)";

    try{
        //instanciacion base de datos
        $db = new db();

        //conexion
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->execute();
        echo '{"notice": {"text": "Cliente agregado"}';
        
//ala sheee en $stmt->excute() bendito me habia faltado la e jaja execute();

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

//Hacer un update a un cliente segun su id
$app->put('/api/clientes/actualizar/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');

    $nombre = $request->getParam('nombre');
    $apellidos = $request->getParam('apellidos');
    $telefono = $request->getParam('telefono');
    $email = $request->getParam('email');
    $direccion = $request->getParam('direccion');
    $ciudad = $request->getParam('ciudad');
    $departamento = $request->getParam('departamento');

    $consulta = "UPDATE clientes SET
                    nombre          =   :nombre,
                    apellidos       =   :apellidos,
                    telefono        =   :telefono,
                    email           =   :email,
                    direccion       =   :direccion,
                    ciudad          =   :ciudad,
                    departamento    =   :departamento
                WHERE id = $id";

    try{
        //instanciacion base de datos
        $db = new db();

        //conexion
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellidos', $apellidos);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':ciudad', $ciudad);
        $stmt->bindParam(':departamento', $departamento);
        $stmt->execute();
        echo '{"notice": {"text": "Cliente actualizado"}';
        
//ala sheee en $stmt->excute() bendito me habia faltado la e jaja execute();
    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});

//borrar un cliente por id
$app->delete('/api/clientes/borrar/{id}', function(Request $request, Response $response){

    $id = $request->getAttribute('id');    

    $consulta = "DELETE FROM clientes WHERE id = $id";

    try{
        //instanciacion base de datos
        $db = new db();

        //conexion
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->execute();
        $db = null;                
        echo '{"notice": {"text": "Cliente borrado"}';
        
//ala sheee en $stmt->excute() bendito me habia faltado la e jaja execute();

    }catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }

});