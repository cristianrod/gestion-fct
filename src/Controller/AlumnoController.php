<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/alumnos")
 * Class AlumnoController
 * @package App\Controller
 */
class AlumnoController extends Controller
{

    /**
     * @Route("/", name="alumnos")
     * @param Request $request
     * @param AlumnoRepository $alumnos
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function index(Request $request, AlumnoRepository $alumnos): Response
    {
        $pagina = $request->query->getInt('p', 1);
        $alumnos = $alumnos->findByNombre($pagina);
        return $this->render("alumno/index.html.twig",[
            'alumnos' => $alumnos
        ]);
    }

    /**
     * @Route("/agregar", name="alumnos_new")
     * @param Request $request
     * @return Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function new(Request $request): Response
    {
        $alumno = new Alumno();

        $form = $this->createForm(AlumnoType::class, $alumno)
            ->add('crear', SubmitType::class, [
                'label' => 'label.crearAlumno',
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alumno = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($alumno);
            $em->flush();
            $this->addFlash('success', 'flash.creadoA');
            return $this->redirectToRoute('alumnos');
        }

        return $this->render("alumno/new.html.twig", [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/{id}", requirements={"id": "\d+"}, name="alumnos_show")
     * @Method("GET")
     * @param Alumno $alumno
     * @return Response
     */
    public function show(Alumno $alumno): Response
    {
        return $this->render('alumno/show.html.twig', [
            'alumno' => $alumno,
        ]);
    }

    /**
     * @Route("/eliminar/{id}", name="alumnos_delete")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Alumno $alumno
     * @return Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delete(Request $request, Alumno $alumno): Response
    {
        if ($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();
            $em->remove($alumno);
            $em->flush();
            $this->addFlash('success', 'flash.borrarA');
            return $this->redirectToRoute('alumnos');
        }
        return $this->render('alumno/delete.html.twig',[
           'alumno' => $alumno,
        ]);
    }

    /**
     * @Route("/actualizar/{id}", name="alumnos_edit")
     * @Method({"GET", "POST"})
     * @param Request $request
     * @param Alumno $alumno
     * @return Response
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function edit(Request $request, Alumno $alumno): Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno)
            ->add('editar', SubmitType::class, [
                'label' => 'label.editarAlumno',
                'attr' => [
                    'class' => 'btn btn-success'
                ],
            ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $em->flush();

            $this->addFlash('success', 'flash.editA');
            return $this->redirectToRoute('alumnos');
        }
        return $this->render('alumno/edit.html.twig',[
            'alumno' => $alumno,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/pdf", name="pdf_alumnos")
     * @return Response
     * @Security("has_role('ROLE_USER')")
     */
    public function pdf(): Response
    {
        $alumnoRepo = $this->getDoctrine()->getRepository(Alumno::class);
        $alumnos = $alumnoRepo->findAll();
        $html = $this->renderView('pdf/alumnos.html.twig', [
            'alumnos' => $alumnos
        ]);

        return new PdfResponse(
            $this->get('knp_snappy.pdf')->getOutputFromHtml($html),
            'listadoalumnos.pdf'
        );
    }
}
