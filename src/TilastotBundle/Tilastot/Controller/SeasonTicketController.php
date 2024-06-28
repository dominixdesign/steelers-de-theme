<?php
namespace App\Tilastot\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Contao\CoreBundle\Framework\ContaoFramework;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Contao\Email;

class SeasonTicketController {
  public function order(Request $request, MailerInterface $mailer, ContaoFramework $framework): Response
  {
    
    $framework->initialize();
    $data = $request->request->all();

    $data['price'] = self::getTicketPrice($data['ticket_area'], $data['ticket_category'], substr($data['seat_block'], -1), $data['ticket_type']);

    $email = new TemplatedEmail();
    $email->subject('Steelers Dauerkarte - Bestellung');
    $email->from('webseite@steelers.de');
    $email->replyTo('ticketing@steelers.de');

    $email->to($data['customer_email']);
    $email->htmlTemplate('@Contao_App/email_season_ticket_confirmation.html.twig');
    $email->context($data);
    
    $mailer->send($email);

    $email2 = new Email();
    $email2->subject = 'Steelers Dauerkarte - Bestellung';
    $email2->from = 'webseite@steelers.de';

    $email2->text = json_encode($data, JSON_PRETTY_PRINT);
    $email2->sendTo('ticketing@steelers.de');

    return new Response('Hello World!');
  }

  private function getPrices($type, $block, $category): int
  {
    $prices = [
      "plus" => [
        "A,G" => [
          "vollzahler" => 720,
          "ermaessigt" => 624,
          "jugendlich" => 432,
          "kind" => 360,
          "behinderung" => 360
        ],
        "B,F,H,L" => [
          "vollzahler" => 624,
          "ermaessigt" => 528,
          "jugendlich" => 384,
          "kind" => 312,
          "behinderung" => 312
        ],
        "C,I,K" => [
          "vollzahler" => 528,
          "ermaessigt" => 456,
          "jugendlich" => 312,
          "kind" => 264,
          "behinderung" => 264,
          "familie1" => 792,
          "familie2" => 1056,
          "familie3" => 1200
        ],
        "J" => [
          "vollzahler" => 384,
          "ermaessigt" => 336,
          "jugendlich" => 240,
          "kind" => 192,
          "behinderung" => 192
        ],
        "R1,R3,R4" => [
          "rollstuhl" => 336
        ]
      ],
      "basic" => [
        "A,G" => [
          "vollzahler" => 570,
          "ermaessigt" => 494,
          "jugendlich" => 342,
          "kind" => 285,
          "behinderung" => 285,
        ],
        "B,F,H,L" => [
          "vollzahler" => 494,
          "ermaessigt" => 418,
          "jugendlich" => 304,
          "kind" => 247,
          "behinderung" => 247
        ],
        "C,I,K" => [
          "vollzahler" => 418,
          "ermaessigt" => 361,
          "jugendlich" => 247,
          "kind" => 209,
          "behinderung" => 209,
          "familie1" => 627,
          "familie2" => 836,
          "familie3" => 950
        ],
        "J" => [
          "vollzahler" => 304,
          "ermaessigt" => 266,
          "jugendlich" => 190,
          "kind" => 152,
          "behinderung" => 152
        ],
        "R1,R3,R4" => [
          "rollstuhl" => 266
        ]
      ]
    ];

    return $prices[$type][$block][$category];
  }
  private function getTicketPrice($area, $category, $block, $type): int
  {
    $reducedCategories = ['rentner', 'student', 'azubi', 'schueler', 'mitglied'];
    $category = in_array($category, $reducedCategories) ? 'ermaessigt' : $category;

    if ($area === 'stehplatz') {
      return $this->getPrices($type, 'J', $category);
    }
    if ($area === 'rollstuhl') { 
      return $this->getPrices($type, 'R1,R3,R4', 'rollstuhl');
    }

    $blockMap = [
      'A' => 'A,G',
      'G' => 'A,G',
      'B' => 'B,F,H,L',
      'F' => 'B,F,H,L',
      'H' => 'B,F,H,L',
      'L' => 'B,F,H,L',
      'C' => 'C,I,K',
      'I' => 'C,I,K',
      'K' => 'C,I,K',
    ];

    $mappedBlock = $blockMap[$block] ?? null;

    return $mappedBlock ? $this->getPrices($type, $mappedBlock, $category) : 0;
  }
}