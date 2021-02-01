<?php

namespace App\Http\BusinessLayers;
use App\Http\Repositories\DetalleRepository;
use Symfony\Component\VarDumper\VarDumper;
use App\Helpers\EstadoTransaccion;

class Detalle
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function listar(){
        try {
            $detalles = new DetalleRepository();
            $respuesta   =$detalles->listar();
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function buscarDetalle($id){
        try {
            $detalleRepo = new DetalleRepository();
            $respuesta   =$detalleRepo->buscarDetalleFactura($id);
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }     
    }

    /*public function insertarActualizar($datos,$evento){     
        try{
            $et             = new EstadoTransaccion();
            $personaRepo    = new PersonaRepository($datos);
            $respuesta      = $personaRepo->insertarActualizar($evento);
            if($respuesta==0){
                $et->existeError    = true;
                $et->mensaje        = $et->PROCESO_ERRONEO;
            }
            return $et;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public function eliminadoFisico($id){
        try{
            $et             = new EstadoTransaccion();
            $personaRepo    = new PersonaRepository();
            $et->data       = $personaRepo->eliminadoFisico($id);          
            return $et;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
    */
}