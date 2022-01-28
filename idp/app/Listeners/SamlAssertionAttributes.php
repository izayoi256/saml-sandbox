<?php

namespace App\Listeners;

use CodeGreenCreative\SamlIdp\Events\Assertion;
use LightSaml\Model\Assertion\Attribute;
use function auth;

class SamlAssertionAttributes
{
    public function handle($event)
    {
        if (!($event instanceof Assertion)) {
            return;
        }

        $event->attribute_statement
            ->addAttribute(new Attribute('userId', auth()->user()->id));
    }
}
