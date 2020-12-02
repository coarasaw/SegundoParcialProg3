<?php
namespace App\Controllers;
use App\Models\Turno;
use \Firebase\JWT\JWT;

class TurnoController {

    public function add($request, $response, $args)
    {
        //Obtemos datos del body
        $dato = $request->getParsedBody();
        $tipo = $dato['tipo']?? '';
        $fecha = $dato['fecha']?? '';
        //$precio = $dato['precio']?? '';
        

        if(isset($tipo) && isset($fecha)){

            // Graba en la Base de Datos
            $user = new Turno;                      
            $user->tipo = $tipo;
            $user->fecha = $fecha;
            //$user->precio = $precio;
            
            
            $rta = $user->save();

            $response->getBody()->write(json_encode($rta));
            return $response;
        }else{
            $response->getBody()->write(json_encode("Error en la carga de Datos para Sacar Turno"));
            return $response;
        }
    }

    public function update($request, $response, $args)
    {   
        $id = $args['id'];
        /* var_dump($id);
        die(); */

        $user = Turno::find($id);

        $user->precio = 100;

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
}