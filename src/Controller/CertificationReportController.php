<?php


namespace App\Controller;

use App\Entity\CertificationReport;
use App\Entity\Remodeling;
use Knp\Bundle\SnappyBundle\Snappy\Response\PdfResponse;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/certification-report", name="certification_report_")
 */
class CertificationReportController extends AbstractController
{
    /**
     * @Route("/certification-report/{remodelingId}/create", name="create")
     * @param Pdf $pdfService
     * @param int $remodelingId
     * @return PdfResponse
     */
    public function generatePdf(Pdf $pdfService, int $remodelingId)
    {
        $remodeling = $this->getDoctrine()->getRepository(Remodeling::class)->find($remodelingId);
        $certificationReportOrder = 1;
        foreach ($remodeling->getCertificationReports() as $value) {
            $certificationReportOrder++;
        }

        $certificationReport = new CertificationReport($certificationReportOrder, false);
        $remodeling->addCertificationReport($certificationReport);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($remodeling);
        $entityManager->persist($certificationReport);
        $entityManager->flush();

        $this->addFlash(
            'success',
            '¡Certificado generado!'
        );

        return new PdfResponse(
            $pdfService->getOutputFromHtml(
                $this->renderView('certification-report/certification-report.html.twig',
                    [
                        'remodeling' => $remodeling
                    ]
                )),
            'certificate-' . $remodeling->getId() . '-' . $certificationReportOrder . '.pdf'
        );
    }

    /**
     * @Route("/update/{certificateId}", name="update")
     * @param int $certificateId
     * @return Response
     */
    public function update(int $certificateId)
    {
        $certificate = $this->getDoctrine()->getRepository(CertificationReport::class)->find($certificateId);
        $certificate->setFinished(true);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($certificate);
        $entityManager->flush();

        $this->addFlash(
            'success',
            '¡Certificado actualizado!'
        );

        return new Response('¡Certificado actualizado!', 201);
    }
}