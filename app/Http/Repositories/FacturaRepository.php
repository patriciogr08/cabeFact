<?php

namespace App\Http\Repositories;
use Illuminate\Support\Facades\DB; 
use App\Http\Repositories\DetalleRepository;
use PhpParser\Node\Stmt\TryCatch;

class FacturaRepository{
    private $cab_id;
    private $cab_cliente;
    private $cab_estado;

    public function __construct($data=NULL){
        $this->cab_id        =   $data['cab_id']         ??null;
        $this->cab_cliente   =   $data['cab_cliente']     ??null;
        $this->cab_estado    =   $data['cab_estado']   ??null;
    }

    public function listar(){
        try {
            $respuesta=DB::select("SELECT * from cabecera where cab_estado='A'");
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }

    public function buscarCabecera($id){
        try {
            $respuesta=DB::select("SELECT * from cabecera where cab_estado='A' and cab_id=$id");
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }   
    }

    public function insertarCabecera(){
        try {   
            $respuesta = DB::select("SELECT insertarcabecera('$this->cab_cliente','A')");
            return $respuesta;
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }  
    }

    public function actualizarCabecera(){
        try {
            $respuesta = DB::update("UPDATE cabecera set cab_cliente='$this->cab_cliente'");
            return $respuesta;
        } catch (\Exception $e) {       
            throw new \Exception($e->getMessage());
        }       
    }
    
    /*public function insertarActualizar($evento){
        try {
            if($evento =="update"){
                DB::update("UPDATE persona
                SET nombre= '$this->nombre',apellido='$this->apellido',email='$this->email'
                where id=$this->id");
                $respuesta=1;
            }else{
                if($this->id!=NULL){
                    DB::insert("INSERT INTO persona(id,nombre,apellido,email) values
                    ($this->id,'$this->nombre','$this->apellido','$this->email')");
                    $respuesta=1;
                }else{
                    $respuesta=0;
                }
            }
            return $respuesta;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }  
    }

    public function eliminadoFisico($id){
        try {
            $respuesta=DB::delete("DELETE FROM persona WHERE id=$id");
            return $respuesta;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }       
    }
*/
}