<?php

namespace App\Controller;

use App\Entity\Sector;
use App\Form\SectorType;
use App\Repository\SectorRepository;
use App\Repository\EmpresaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SectorController extends AbstractController
{

    
    
public function listadoSectores(SectorRepository $sector,$error = 0)
    {
        
        $sectores =  $sector->sectores();
        
        return  new response($this->render('sector/index.html.twig', [
            'sectores' => $sectores,'error'=>$error
        ]));
    }

    public function NuevoSector(Request $request ,SectorRepository $sectorRep)
    {
        $sector = new Sector();
        $form = $this->createForm(SectorType::class, $sector);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $error = $sectorRep->EditarInsertarSector($form,'INSERT');
            
            
            return $this->redirectToRoute('sectores', ['error' => $error], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sector/new.html.twig', [
            'sector' => $sector,
            'form' => $form,
        ]);
    }
    
    
    
   
        
        
    
    
   
    public function edit(Request $request, Sector $sector,SectorRepository $sectores)
    {
    
        $idSector = $request->get('id');
       
        $form = $this->createForm(SectorType::class, $sector);
     
      $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            
            
                   $sector = $sectores->EditarInsertarSector($form,'MOD',$idSector);
            


            return $this->redirectToRoute('sectores', [], Response::HTTP_SEE_OTHER);
        }

  return $this->renderForm('sector/edit.html.twig', [
            'sector' => $sector,
            'form' => $form,
        ]);
    }

    public function delete(Request $request, SectorRepository $sectorRepository,$id= 0): Response
    {
      $sector  =  $sectorRepository->sector($id);
      
        if ($sector->getID () == $id) {
              
          $error =  $sectorRepository->borrarSector($id);
         
        }

        return $this->redirectToRoute('sectores',  ['error' => $error], Response::HTTP_SEE_OTHER);
    }
}
