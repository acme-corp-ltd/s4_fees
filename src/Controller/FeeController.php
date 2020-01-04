<?php


namespace App\Controller;


use App\Entity\Fee;
use App\Repository\FeeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FeeController extends AbstractFOSRestController implements ClassResourceInterface
{
    protected $feeRepository;
    protected $entityManager;

    public function __construct(FeeRepository $feeRepository, EntityManagerInterface $entityManager)
    {
        $this->feeRepository = $feeRepository;
        $this->entityManager = $entityManager;
    }

    public function cgetAction()
    {
        $entities = $this->feeRepository->findAll();
        return $this->view($entities, 200)
            ->setTemplate('datatable.html.twig')
            ->setTemplateVar('datalist');
    }

    /**
     * @Rest\Route("/fees", methods={"put"})
     * @ParamConverter("input", class="array<App\Entity\Fee>", converter="fos_rest.request_body")
     * @param array $input
     * @return Response
     */
    public function replaceAction(array $input) {
        $current = $this->feeRepository->findAll();
        foreach ($current as $item) {
            $this->entityManager->remove($item);
        }
        foreach ($input as $item) {
            $this->entityManager->persist($item);
        }
        $this->entityManager->flush();

        return new Response(200);
    }

    /**
     * @Rest\Route("/fees/{category}/{amount}.{_format}")
     * @param $category
     * @param $amount
     * @return View
     */
    public function lookupFee($category, $amount)
    {
        $amount = bcadd(trim($amount), '0', 2);
        $category = trim($category);

        try {
            $fee = $this->feeRepository->findOneByCategoryAmount($category, $amount);
        } catch (NonUniqueResultException $e) {
            throw new BadRequestHttpException();
        }

        return $this->view($fee, 200)
            ->setTemplate('datatable.html.twig')
            ->setTemplateVar('dataitem');
    }

}