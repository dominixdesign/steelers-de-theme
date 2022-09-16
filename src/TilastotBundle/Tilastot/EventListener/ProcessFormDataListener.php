<?php

namespace App\Tilastot\EventListener;

use Contao\CoreBundle\ServiceAnnotation\Hook;
use Contao\Form;

/**
 * @Hook("processFormData")
 */
class ProcessFormDataListener
{
  public function __invoke(
    array $submittedData,
    array $formData,
    ?array $files,
    array $labels,
    Form $form
  ): void {

    var_dump($submittedData);
  }
}