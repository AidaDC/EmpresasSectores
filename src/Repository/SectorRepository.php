<?php

namespace App\Repository;

use App\Entity\Sector;
use App\Entity\Empresa;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


/**
 * @method Sector|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sector|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sector[]    findAll()
 * @method Sector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sector::class);
    }
    
    
    /*
     * Función que devuelve un listado de sectores
     */
    
    public function sectores() {
        
        $entityManager = $this->getEntityManager();
        $sectores = $entityManager->getRepository(Sector::class)->findAll();
         
        return $sectores;
         
    }
    
      
   public function sector($valor){
         $entityManager = $this->getEntityManager();
         $sector= $entityManager->getRepository(Sector::class)->find($valor);
         
        return $sector;
         
    }
    



     public function borrarSector($valor) {
          $error = 0;   
          $entityManager = $this->getEntityManager();
        try{
       
  
  
            $sector =   $this->sector($valor);
            
        $empresa = $this->empresaSector($valor);
         
         if(!$empresa){
         
         if($sector){
            
             $entityManager->remove($sector);
             $entityManager->flush(); 
             
         }
         }else{
            $error =1;  
         }
         
         
        return $error;
        } catch (Exception $e){
               $error =2;  
            return $error;
            
        } 
    }
    
    
    public function empresaSector($valor,$nombre='borrar'){
        
        
          $error = 2;   
          $entityManager = $this->getEntityManager();
        try{
       

        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Empresa p
            WHERE p.Sector = :sector'
        )->setParameter('sector', $valor);

       
        $empresa = $query->getResult();
        
        
        return $empresa;
        
         } catch (Exception $e){
            
            return $error;
            
        } 
    }
 
 // /**
    //   Metodo que actualiza un registro de la tabla Sector, comprobando antes si existe uno  con esos datos,
    //    en ese caso lo modifica.
    //  * 
    //  */
   
    public function EditarInsertarSector($form,$ModInd,$value = 0)
    {
        $sector= '';
         $entityManager = $this->getEntityManager();
 try{  
     
 
  
        $error = 0;
  
        if($ModInd == 'INSERT'){
                $sectores = $entityManager->getRepository(Sector::class)->find($value);
     if(is_null($sectores)) {
            $sector  = new Sector();
            
         $empresa = $this->empresaSector($form->getData()->getNombre(),'mod');
            
              $sector->setNombre($form->getData()->getNombre());
              $entityManager->persist($sector);
                 $entityManager->flush();
            $error = 7;
            }else{
               $error = 3; 
            } 
      
        }elseif ( $ModInd == 'MOD') {
            
          $sectoresMod = $entityManager->getRepository(Sector::class)->find($value);


                if($sectoresMod->getId() == $value){

               
                     $sectoresMod->setNombre($form->getData()->getNombre());
                     $entityManager->persist($sectoresMod);
                     $error = 8;
                  
                        }else{
                            
                            $error =3;
                        }

                
          
               $entityManager->flush();
        
             
         }else{
             
             $error =1;
         }
        return $error;
        }catch (Exception $e){
            $error =2;
            return $error;

        }
 }           
    
    
}
