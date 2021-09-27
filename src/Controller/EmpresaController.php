<?php

namespace App\Controller;

use App\Entity\Empresa;
use App\Form\EmpresaType;
use App\Repository\EmpresaRepository;
use App\Repository\SectorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EmpresaController extends AbstractController
{
    public function listado(EmpresaRepository $empresaRepository,SectorRepository $sector,$error = 0)
    {
        
        $empresas =  $empresaRepository->ListaEmpresas($sector);
        
        
        
        return  new response($this->render('empresa/index.html.twig', [
            'empresas' => $empresas,
            'error' =>$error
        ]));
    }
    
    /* Función que inserta una nueva empresa */

    public function NuevaEmpresa(Request $request,EmpresaRepository $empresaRepository,SectorRepository $sector)
    {
        $empresa = new Empresa();
        
     
        
       $sectores =$sector->sectores();
        $form = $this->createForm(EmpresaType::class, $empresa);
        
     
     
     $form->handleRequest($request);

        
        if ($form->isSubmitted()) {
                
            
                   $error = $empresaRepository->EditarInsertarEmpresa($form,'INSERT',$request->request->get('empresa')['Sector']);
            


            return $this->redirectToRoute('empresas', ['error' =>$error], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('empresa/new.html.twig', [
            'empresa' => $empresa,
            'sectores' => $sectores,
            'form' => $form
        ]);
    }


/* Función que abre un formulario con datos de la empresa selecionada y así poder editarla

 *  */
    public function edit(Request $request, Empresa $empresa , EmpresaRepository $empresaRepository,SectorRepository $sector)
    {
         //$empresa = new Empresa();
          $idEmpresa = $request->get('id');
       
         $sectores =$sector->sectores();
        $form = $this->createForm(EmpresaType::class, $empresa);
        $form->handleRequest($request);
 
        if ($form->isSubmitted()) {
           
                $error = $empresaRepository->EditarInsertarEmpresa($form,'MOD',$request->request->get('empresa')['Sector'],$idEmpresa);


            return $this->redirectToRoute('empresas', ['error' =>$error], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('empresa/edit.html.twig', [
             'empresa' => $empresa,
            'sectores' => $sectores,
            'form' => $form,
        ]);
    }

    
    /*Función que borra un registro de la tabla empresas*/
    public function delete(Request $request,EmpresaRepository $empresaRepository,$id= 0)
    {
        
    
        $empresa =  $empresaRepository->Empresa($id);
      
        if ($empresa->getID () == $id) {
              
          $error =  $empresaRepository->borrarEmpresa($id);
          
        }

        return $this->redirectToRoute('empresas', [], Response::HTTP_SEE_OTHER);
    }
    
    
}
