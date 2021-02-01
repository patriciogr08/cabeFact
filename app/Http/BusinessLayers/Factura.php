<?php

namespace App\Http\BusinessLayers;
use App\Helpers\EstadoTransaccion;
use App\Http\Repositories\DetalleRepository;
use App\Http\Repositories\FacturaRepository;
use Illuminate\Support\Facades\DB;
use Symfony\Component\VarDumper\VarDumper;

class Factura
{
    public function listar(){
        try {
          
            $cabecera = new FacturaRepository();
            $respuesta   =(array) $cabecera->listar();
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function buscarCabecera($id){
        try {
            $cabeceraRepo = new FacturaRepository();
            $respuesta   =$cabeceraRepo->buscarCabecera($id);
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
 
    public function listarFacturasDetalle(){
        $listaFacturas =array();
        $reposDetalle  = new DetalleRepository();
        try {
            $cabeceras =$this->listar();
            foreach($cabeceras as $cabe){
                $detalles   = $reposDetalle->buscarDetalleFactura($cabe->{'cab_id'});
                $factura    = array('cabecera'=>$cabe,'detalle'=>$detalles);
                $listaFacturas[]=$factura;
            }
            return ($listaFacturas);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }

    public function listarFacturaDetalle($id){
        $reposDetalle = new DetalleRepository();
        try {
            $cabecera   =$this->buscarCabecera($id);
            $detalles   = $reposDetalle->buscarDetalleFactura($id);
            $factura    = array('cabecera'=>$cabecera,'detalle'=>$detalles);
            return ($factura);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }

    public function grabarFactura($datos){
        try {
            $et             = new EstadoTransaccion();
            $cabeceera      =($datos['cabecera']);
            $cabeceraRepo   = new FacturaRepository($cabeceera[0]);
            DB::beginTransaction();
            $respuesta      = $cabeceraRepo->insertarCabecera();
            $idGenerado     = $respuesta[0]->{'insertarcabecera'};
            if($idGenerado==0){
                $et->existeError    = true;
                $et->mensaje        = $et->PROCESO_ERRONEO;
                DB::rollBack();
            }
            else{
                $detalle=$datos['detalle'];
                foreach($detalle as $deta){
                    $detalleRepo = new DetalleRepository($deta);
                    $respuesta2  = $detalleRepo->insertarDetalle($idGenerado);
                    print_r($respuesta2);
                    if($respuesta2==0){
                        $et->existeError    = true;
                        $et->mensaje        = $et->PROCESO_ERRONEO;
                        DB::rollBack();
                    } 
                }
                DB::commit();
                return $et;
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }  
    }
}