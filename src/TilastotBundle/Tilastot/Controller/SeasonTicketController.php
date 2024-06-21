<?php
// src/Controller/SeasonTicketController.php
namespace App\Tilastot\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeasonTicketController
{
  public function order(Request $request): Response
  {
    $data = json_decode($request->getContent(), true);  
    var_dump($data);
    return new Response('Hello World!');
  }
}