<?php
namespace AppBundle\Controller;

use Symfony\Bundle\TwigBundle\Controller\ExceptionController;
use Symfony\Component\HttpFoundation\Request;

class ErrorController extends ExceptionController
{
    protected function findTemplate(Request $request, $format, $code, $showException)
    {
        if (!$showException) {
            $templates = [
                sprintf('%s.%s.twig', $code, $format),
                sprintf('%sxx.%s.twig', substr($code, 0, 1), $format),
            ];

            foreach ($templates as $template) {
                $templateFile = '_error/'.$template;
                if ($this->templateExists($templateFile)) {
                    return $templateFile;
                }
            }
        }

        return parent::findTemplate($request, $format, $code, $showException);
    }
}
