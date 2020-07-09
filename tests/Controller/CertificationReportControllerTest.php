<?php


namespace App\Tests\Controller;

use App\Entity\CertificationReport;
use App\Repository\CertificationReportRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CertificationReportControllerTest
 * @package App\Tests\Controller
 * @coversDefaultClass \App\Controller\CertificationReportController
 */
class CertificationReportControllerTest extends WebTestCase
{
    const CERTIFICATION_REPORT_PATH = '/certification-report';
    const LOGIN_PATH = '/login';
    const REMODELING_PATH = '/remodeling';

    /**
     * @var KernelBrowser $client
     */
    private static $client;

    public static function setUpBeforeClass():void
    {
        self::$client= static::createClient();
    }

    /**
     * Implements testGeneratePdfOk
     * @return CertificationReport $certificationReport
     * @covers ::generatePdf
     */
    public function testGeneratePdfOk()
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        self::$client->request('GET', self::REMODELING_PATH.'/');
        $crawler = new Crawler(self::$client->getResponse()->getContent(), 'http://localhost/remodeling/');
        $remodelingId = $crawler->filter('tbody>tr>td')->first()->text();
        $generatePdfLink = $crawler->selectLink('Generar certificado')->link();
        self::$client->click($generatePdfLink);

        self::bootKernel();
        $certificationReport = self::$container->get(CertificationReportRepository::class)->findOneByRemodeling($remodelingId);
        $response = self::$client->getResponse();
        self::assertEquals(Response::HTTP_OK, $response->getStatusCode());
        self::assertNotEmpty($certificationReport);

        return $certificationReport;
    }

    /**
     * Implements testUpdateCertificationUpdated
     * @param CertificationReport $certificationReport
     * @return void
     * @covers ::update
     * @depends testGeneratePdfOk
     */
    public function testUpdateCertificationUpdated(CertificationReport $certificationReport)
    {
        self::$client->request('GET', self::LOGIN_PATH);
        self::$client->submitForm('Acceder', [
            'email' => 'admin@mail.com',
            'password' => '1234'
        ], 'POST');

        $certificationId = $certificationReport->getId();
        self::$client->xmlHttpRequest('POST', self::CERTIFICATION_REPORT_PATH.'/update/'.$certificationId);

        self::bootKernel();
        $certificationReport = self::$container->get(CertificationReportRepository::class)->findOneById($certificationId);
        self::assertTrue($certificationReport->getFinished());
    }


}