<?php

namespace App\Repository;

use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use App\Repository\SectorRepository;

/**
 * Clase que engloba todos los metodos que tienen que ver con la empresa, como eliminar,
 *  editar o buscar una empresa en concreto. Además de el listado.
 */
 
 
class EmpresaRepository extends ServiceEntityRepository
{
    
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Empresa::class);
    }

    // /**
    //   Metodo que actualiza un registro de la tabla Empresa, comprobando antes si existe una empresa con esos datos
    //  * @return Boolean
    //  */
   
    public function EditarInsertarEmpresa($form, $ModInd,$sector, $value=0)
    {
        $empresa= '';
         $entityManager = $this->getEntityManager();
       
try{  

  
  
          $error = 0;
        if($ModInd == 'INSERT'){
                  if(!$this->is_valid_email($form->getData()->getEmail())){
                        
                         $error = 5;
                        
                    }else{
    
              $empresa  = new Empresa();
              $empresa->setNombre($form->getData()->getNombre());
              $empresa->setEmail($form->getData()->getEmail());
              $empresa->setTelefono($form->getData()->getTelefono());
              $empresa->setSector($sector);
              $entityManager->persist($empresa);
              $entityManager->flush();      
               $error = 6;
            
                    }
            
        }elseif ( $ModInd == 'MOD') { 
            
              $empresa = $entityManager->getRepository(Empresa::class)->find($value);

          

                if($empresa->getId() == $value){
                    
                    if(!$this->is_valid_email($form->getData()->getEmail())){
                       
                         $error = 5;
                        
                    }else{
                        
                    
                        
                        if( $empresa->getNombre() != $form->getData()->getNombre()){
                           $empresa->setNombre($form->getData()->getNombre());
                        }

                           if( $empresa->getEmail() != $form->getData()->getEmail()){
                           $empresa->setEmail($form->getData()->getEmail());
                        }

                         if( $empresa->getTelefono() != $form->getData()->getTelefono()){
                           $empresa->setTelefono($form->getData()->getTelefono());
                        }

                           if( $empresa->getSector() != $sector){
                           $empresa->setSector($sector);
                        }

                     $entityManager->flush();
                    $error = 9;


                    }

                  
                }
           
            
             
             $entityManager->close();
         }
        return $error;
        }catch (Exception $e){
            $error =2;
            return $error;

        }
            }
        
        
    
    /*
     * Función que devuelve un listado con todos las empresas y el nombre del sector al que perteenecen
     * 
     * @author Aida Dahdah
     */

   
   public function ListaEmpresas($sectorRep)
    {
       //$entityManager = $this->getEntityManager();
       $empresas = $this->empresas();
     $empresa = [];
     $sector =[];
     $arrayEmp = [];
       $sectores = $sectorRep->sectores();
       $NSector = '';
       $i = 0;
      
         foreach( $empresas as $empresa){
             $arrayEmp[$i]['id'] =$empresa->getID(); 
             $arrayEmp[$i]['Nombre'] =$empresa->getNombre(); 
             $arrayEmp[$i]['Telefono'] =$empresa->getTelefono(); 
             $arrayEmp[$i]['Email'] =$empresa->getEmail(); 
                  
             foreach ($sectores as $sector){
                 if($empresa->getSector() == $sector->getID()){
                     $NSector = $sector->getNombre();
                   
                 }
                 
                  
                 
             }
             $arrayEmp[$i]['Sector'] =$NSector; 
             $i++;
         }
         
         
 
        
        return $arrayEmp;
        
        
    }

    private function empresas() {
        
        $entityManager = $this->getEntityManager();
        $empresas = $entityManager->getRepository(Empresa::class)->findAll();
         
        return $empresas;
         
    }
    
    
   
    public function empresa($valor) {
        
         $entityManager = $this->getEntityManager();
         $empresa = $entityManager->getRepository(Empresa::class)->find($valor);
         
        return $empresa;
         
    }
    



     public function borrarEmpresa($valor) {
         $error = 0;   
          $entityManager = $this->getEntityManager();
        try{
          
         $empresa = $entityManager->getRepository(Empresa::class)->find($valor);
         
         if($empresa){
             $entityManager->remove($empresa);
             $entityManager->flush();
             
         }
         
         return $error;
        } catch (Exception $e){
             $error = 2;   
            return $error;
            
        } 
         
    }



    private function is_valid_email($str)
    {
        $matches = null;
        $mail = (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
    
        
        return $mail;
    }


}