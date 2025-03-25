<?php

namespace App\Controller;

use App\Entity\HistorialViaxes;
use App\Form\HistorialViaxesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;


final class ViaxesController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/viaxes', name: 'app_viaxes')]
    public function rexistrarViaxes(EntityManagerInterface $entityManager): Response
    {
        $viaxes = [
            ['destino' => 'Madrid', 'data' => '2025-03-10', 'duracion' => 5, 'motivo' => 'Traballo', 'transporte' => 'Avión', 'aloxamento' => 'Hotel Sol'],
            ['destino' => 'Barcelona', 'data' => '2025-04-15', 'duracion' => 3, 'motivo' => 'Vacacións', 'transporte' => 'Tren', 'aloxamento' => 'Airbnb'],
            ['destino' => 'Londres', 'data' => '2025-05-20', 'duracion' => 7, 'motivo' => 'Estudos', 'transporte' => 'Avión', 'aloxamento' => 'Residencia'],
            ['destino' => 'París', 'data' => '2025-06-05', 'duracion' => 4, 'motivo' => 'Ocio', 'transporte' => 'Autobús', 'aloxamento' => 'Hotel Eiffel'],
            ['destino' => 'Roma', 'data' => '2025-07-12', 'duracion' => 6, 'motivo' => 'Cultura', 'transporte' => 'Avión', 'aloxamento' => 'Pensión Italia'],
            ['destino' => 'Berlín', 'data' => '2025-08-18', 'duracion' => 5, 'motivo' => 'Concertos', 'transporte' => 'Coche', 'aloxamento' => 'Hostal Berlinés'],
            ['destino' => 'Lisboa', 'data' => '2025-09-25', 'duracion' => 4, 'motivo' => 'Gastronomía', 'transporte' => 'Tren', 'aloxamento' => 'Hotel Marítimo'],
            ['destino' => 'Amsterdam', 'data' => '2025-10-30', 'duracion' => 5, 'motivo' => 'Arte', 'transporte' => 'Avión', 'aloxamento' => 'Casa de hóspedes'],
        ];

        foreach ($viaxes as $viaxeData) {
            $viaxe = new HistorialViaxes();
            $viaxe->setDestino($viaxeData['destino']);
            $viaxe->setData(new \DateTime($viaxeData['data']));
            $viaxe->setDuracion($viaxeData['duracion']);
            $viaxe->setMotivo($viaxeData['motivo']);
            $viaxe->setTransporte($viaxeData['transporte']);
            $viaxe->setAloxamento($viaxeData['aloxamento']);

            $entityManager->persist($viaxe);
        }

        $entityManager->flush();

        return new Response('8 rexistros de viaxes engadidos correctamente!');
        }

        #[Route('/viaxes/listar', name: 'listar_viaxes')]
        public function listarViaxes(EntityManagerInterface $entityManager): Response
        {
            $viaxes = $entityManager->getRepository(HistorialViaxes::class)->findAll();

            return $this->render('viaxes/index.html.twig', ['viaxes' => $viaxes,]);
        }

        #[Route('/viaxes/detalle/{id}', name: 'detalle_viaxe')]
        public function detalleViaxes(EntityManagerInterface $entityManager, HistorialViaxes $historialViaxes): Response
        {
            return $this->render('viaxes/detalle.html.twig', ['viaxe' => $historialViaxes,]);
        }

        #[Route('/viaxes/editar/{id}', name: 'editar_viaxe')]
        public function editarViaxes(Request $request, EntityManagerInterface $entityManager, HistorialViaxes $viaxe): Response
        {
        $form = $this->createForm(HistorialViaxesType::class, $viaxe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'O viaxe foi actualizado con éxito.');
            return $this->redirectToRoute('listar_viaxes');
        }

        return $this->render('viaxes/form.html.twig', [
            'form' => $form->createView(),
            'is_edit' => true,
        ]);
        }

        #[Route('/viaxes/crear', name: 'crear_viaxe')]
        public function crearViaxes(Request $request, EntityManagerInterface $entityManager): Response
        {
            $viaxe = new HistorialViaxes();
            $form = $this->createForm(HistorialViaxesType::class, $viaxe);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $entityManager->persist($viaxe);
                $entityManager->flush();

                $this->addFlash('success', 'O viaxe foi creado con éxito.');
                return $this->redirectToRoute('listar_viaxes');
            }

            return $this->render('viaxes/form.html.twig', [
                'form' => $form->createView(),
                'is_edit' => false,
            ]);
        }
        
        #[Route('/viaxes/eliminar/{id}', name: 'eliminar_viaxe', methods: ['POST', 'DELETE'])]
        public function eliminarViaxe(Request $request, EntityManagerInterface $entityManager, HistorialViaxes $viaxe): Response
        {
            if ($this->isCsrfTokenValid('eliminar' . $viaxe->getId(), $request->request->get('_token'))) {
                $entityManager->remove($viaxe);
                $entityManager->flush();

                $this->addFlash('success', 'O viaxe foi eliminado con éxito.');
            } else {
                $this->addFlash('danger', 'Token CSRF inválido.');
            }

            return $this->redirectToRoute('listar_viaxes');
    }

    #[Route('/viaxes/estadisticas', name: 'estadisticas_viaxes')]
    public function estadisticasViaxes(EntityManagerInterface $entityManager): Response
    {
        $cuenta = $entityManager->getRepository(HistorialViaxes::class)->count([]);
        $viaxes = $entityManager->getRepository(HistorialViaxes::class)->findAll();
        $sum=0;
 
        foreach ($viaxes as $viaxe){
            $sum += $viaxe->getDuracion();
        }

        $media = $sum/$cuenta;

        return $this->render('viaxes/estadisticas.html.twig', ['cuenta' => $cuenta, 'media' => $media]);
    }
}
