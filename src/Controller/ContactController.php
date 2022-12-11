<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
  #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
  public function index(Request $request, EntityManagerInterface $manager, MailerInterface $mailer): Response
  {
    $contact = new Contact();
    if ($this->getUser()) {
      $contact->setNom($this->getUser()->getNom())
        ->setPrenom($this->getUser()->getPrenom())
        ->setEmail($this->getUser()->getEmail());
    }

    $form = $this->createForm(ContactType::class, $contact);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {

      $contact = $form->getData();
      $contact->setCreatedAt(new \DateTimeImmutable('now'));

      $manager->persist($contact);
      $manager->flush();

      $email = (new TemplatedEmail())
        ->from($contact->getEmail())
        ->to('admin@nb-facialiste.fr');
      if ($contact->getSujet() !== null) {
        $email->subject($contact->getSujet());
      }
      $email->htmlTemplate('email/contact.html.twig')

        // pass variables (name => value) to the template
        ->context([
          'contact' => $contact,
        ]);

      $mailer->send($email);

      $this->addFlash('success', 'Votre message a bien été envoyé');
      return $this->redirectToRoute('app_contact', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('home/contact/index.html.twig', [
      'form' => $form->createView(),
    ]);
  }
}
