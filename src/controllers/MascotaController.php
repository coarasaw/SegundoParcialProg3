<?php
namespace App\Controllers;
use App\Models\Mascota;
use \Firebase\JWT\JWT;

class MascotaController {

    public function add($request, $response, $args)
    {
        //Obtemos datos del body
        $dato = $request->getParsedBody();
        $tipo = $dato['tipo']?? '';
        $precio = $dato['precio']?? '';
        

        if(isset($tipo) && isset($precio)){

            // Graba en la Base de Datos
            $user = new Mascota;                       // creo una materia
            $user->tipo = $tipo;
            $user->precio = $precio;
            
            
            $rta = $user->save();

            $response->getBody()->write(json_encode($rta));
            return $response;
        }else{
            $response->getBody()->write(json_encode("Error en la carga de Datos para Macota"));
            return $response;
        }
    }
}