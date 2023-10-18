<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\FileUploadFormType;
use App\Form\FormUserType;
use App\Repository\UserRepository;
use App\Service\CsvService;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Writer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserSpaceController extends AbstractController
{
    #[Route('/user/space', name: 'app_user_space')]
    public function index(UserRepository $repo): Response
    {
        $users = $repo->findAll();
        return $this->render('user_space/index.html.twig', [
            'controller_name' => 'Liste des users',
            'users' => $users,
        ]);
    }

    #[Route('/user/space/show/{id}', name: 'user_space_show')]
    public function show(?User $user, Security $security)
    {
        $currentUser = $security->getUser();
        if ($user === null || $user !== $currentUser) {
            return $this->redirectToRoute('app_user_space');
        }

        return $this->render('user_space/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user/space/new', name: 'user_space_new')]
    public function new (Request $request, EntityManagerInterface $em): Response
    {
        $user = new User();
        $form = $this->createForm(FormUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_space');
        }

        return $this->render('user_space/new.html.twig', [
            'title' => 'Ajouter une personne',
            'form' => $form,
        ]);
    }

    #[Route('/user/space/edit/{id}', name: 'user_space_edit')]
    public function edit(Request $request, ?User $user, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher, Security $security ): Response
    {
        if ($user === null) {
            return $this->redirectToRoute('app_user_space');
        }

        $currentUserInterface = $security->getUser();

        if ($user !== $currentUserInterface) {
            return $this->redirectToRoute('app_user_space');}
        $form = $this->createForm(FormUserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_space');
        }

        return $this->render('user_space/new.html.twig', [
            'title' => 'Editer une personne',
            'form' => $form,
            'button_label' => 'enregistrer',
        ]);
    }

    #[Route('/delete/{id}', name: 'test_delete')]
    public function delete(Request $request, ?User $user, EntityManagerInterface $entityManager , Security $security): Response
    {
        if ($user === null) {
            return $this->redirectToRoute('app_user_space');
        }

        $currentUserInterface = $security->getUser();

        if ($user !== $currentUserInterface) {
            return $this->redirectToRoute('app_user_space');}
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('test_list', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/user/space/collaborator/add/{id}', name: 'user_space_collaborator_add')]
    public function collaboratorAdd(?User $user, EntityManagerInterface $entityManager, Security $security, UserRepository $repo): Response
    {
        if ($user === null) {
            return $this->redirectToRoute('app_user_space');
        }
        $currentUser = $security->getUser();

        if ($user !== $currentUser) {
            $currentUser->addCollaborator($user);//fonctionne malgré l'erreur de type sur VSCode
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_user_space');
    }

    #[Route('/user/space/collaborator/remove/{id}', name: 'user_space_collaborator_remove')]
    public function collaboratorRemove(?User $user, EntityManagerInterface $entityManager, Security $security, UserRepository $repo): Response
    {
        if ($user === null) {
            return $this->redirectToRoute('app_user_space');
        }
        $currentUserInterface = $security->getUser();

        if ($user !== $currentUserInterface) {
            $currentUser = $repo->findByEmail($currentUserInterface->getUserIdentifier());
            $currentUser->removeCollaborator($user);
            $entityManager->persist($currentUser);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_user_space');
    }
    #[Route('/user/space/import/csv/{id}', name: 'import_csv')]
    public function importCsvAction(Request $request, User $user, Security $security, UserRepository $repo, EntityManagerInterface $entityManager): Response
    {
        if ($user === null) {
            return $this->redirectToRoute('app_user_space');
        }

        $currentUserInterface = $security->getUser();

        if ($user !== $currentUserInterface) {
            return $this->redirectToRoute('app_user_space');}
        $form = $this->createForm(FileUploadFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            $email = CsvService::importCsv($file);
            if (!empty($email)) {
                foreach ($email as $value) {
                    var_dump($value);
                    $collaborator = $repo->findByEmail($value);
                    if ($collaborator !== null) {
                        $user->addCollaborator($collaborator);
                        $entityManager->persist($user);
                        $entityManager->flush();
                    }

                }
            }
            return $this->redirectToRoute('app_user_space');
        }

        return $this->render('user_space/import_csv.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/user/space/export/csv/{id}', name: 'export_csv')]
    public function exportCsvAction(User $user, Security $security): Response
    {if ($user === null) {
        return $this->redirectToRoute('app_user_space');
    }

        $currentUserInterface = $security->getUser();

        if ($user !== $currentUserInterface) {
            return $this->redirectToRoute('app_user_space');}

        $collaborators = $user->getCollaborators();
        // Exemple de données à exporter (vous pouvez les remplacer par vos propres données).
        $data = [['nom', 'prenom', 'email', 'addresse']];
        foreach ($collaborators as $collaborator) {
            $data[] = [
                $collaborator->getFirstName(),
                $collaborator->getLastName(),
                $collaborator->getEmail(),
                $collaborator->getAddress(),
            ];
        }

        $csvWriter = Writer::createFromFileObject(new \SplTempFileObject());
        $csvWriter->setDelimiter(';');
        $csvWriter->insertAll($data);
        $response = new Response($csvWriter->toString(), 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="export.csv"',
        ]);

        return $response;
    }

}
