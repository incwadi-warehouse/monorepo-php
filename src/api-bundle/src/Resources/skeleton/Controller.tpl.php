<?= "<?php\n" ?>

namespace <?= $namespace; ?>;

use App\Entity\<?= $entity; ?>;
use App\Form\<?= $entity; ?>Type;
use Baldeweg\Bundle\ApiBundle\AbstractApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

#[Route(path: '/api/<?= $name_lowercase; ?>')]
class <?= $class_name ?> extends AbstractApiController
{
    private $fields = [];

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    #[Route(path: '/', methods: ['GET'])]
    public function index(ManagerRegistry $manager): JsonResponse
    {
        return $this->setResponse()->collection(
            $this->fields,
            $manager->getRepository(<?= $entity; ?>::class)->findAll()
        );
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    #[Route(path: '/{<?= $name_lowercase; ?>}', methods: ['GET'])]
    public function show(<?= $entity; ?> $<?= $name_lowercase; ?>): JsonResponse
    {
        return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    #[Route(path: '/new', methods: ['POST'])]
    public function new(Request $request, ManagerRegistry $manager): JsonResponse
    {
        $<?= $name_lowercase; ?> = new <?= $entity; ?>();
        $form = $this->createForm(<?= $entity; ?>Type::class, $<?= $name_lowercase; ?>);

        $form->submit(
            $this->submitForm($request)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->persist($<?= $name_lowercase; ?>);
            $em->flush();

            return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
        }

        return $this->setResponse()->invalid();
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    #[Route(path: '/{<?= $name_lowercase; ?>}', methods: ['PUT'])]
    public function edit(<?= $entity; ?> $<?= $name_lowercase; ?>, Request $request, ManagerRegistry $manager): JsonResponse
    {
        $form = $this->createForm(<?= $entity; ?>Type::class, $<?= $name_lowercase; ?>);

        $form->submit(
            $this->submitForm($request)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $manager->getManager();
            $em->flush();

            return $this->setResponse()->single($this->fields, $<?= $name_lowercase; ?>);
        }

        return $this->setResponse()->invalid();
    }

    /**
     * @Security("is_granted('ROLE_USER')")
     */
    #[Route(path: '/{<?= $name_lowercase; ?>}', methods: ['DELETE'])]
    public function delete(<?= $entity; ?> $<?= $name_lowercase; ?>, ManagerRegistry $manager): JsonResponse
    {
        $em = $manager->getManager();
        $em->remove($<?= $name_lowercase; ?>);
        $em->flush();

        return $this->setResponse()->deleted();
    }
}
