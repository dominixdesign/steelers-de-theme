<?php
// src/Controller/SeasonTicketController.php
namespace App\Tilastot\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/seasontickets/order', name: SeasonTicketController::class)]
class SeasonTicketController
{
  public function __invoke(Request $request): Response
  {
    $data = json_decode($request->getContent(), true);  
    var_dump($data);
    return new Response('Hello World!');
  }
}