<?php
namespace App\Tilastot\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class SeasonTicketController {
  public function order(Request $request, MailerInterface $mailer, ContaoFramework $framework): Response
  {
    $framework->initialize();
    var_dump($request->request->all());  

    $email = new TemplatedEmail();
    $email->subject('Steelers Dauerkarte - Bestellung');
    $email->from('webseite@steelers.de');
    $email->replyTo('tickets@steelers.de');

    $email->to('dominik.sander@gmail.com');
    $email->htmlTemplate('@Contao_App/email_season_ticket_confirmation.html.twig');
    $email->context($request->request->all());
    
    $mailer->send($email);

    return new Response('Hello World!');
  }
}