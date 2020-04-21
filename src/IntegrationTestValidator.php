<?php
/**
 * Copyright (c) 2018 EXTREME IDEA LLC https://www.extreme-idea.com
 * This software is the proprietary information of EXTREME IDEA LLC.
 *
 * All Rights Reserved.
 * Modification, redistribution and use in source and binary forms, with or without modification
 * are not permitted without prior written approval by the copyright holder.
 *
 */

namespace Elikh;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IntegrationTestValidator extends AbstractLocationClassTestValidator
{
    const TEST_TYPE = 'Integration';

    public function isValid(string $filePath)
    {
        $testClass = $this->getClassName($filePath);

        if ((!is_string($testClass) && !is_object($testClass))
            || (!is_subclass_of($testClass, WebTestCase::class)
                && !is_subclass_of($testClass, KernelTestCase::class))
            || strpos($testClass, 'IntegrationTest') === false
            || strpos($testClass, 'App\Tests\Integration') === false
        ) {
            return false;
        }

        return true;
    }
}
