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

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTestValidator implements TestTypeValidatorInterface
{

    public function isValid(string $filePath, string $testClass)
    {
        if ((!is_string($testClass) && !is_object($testClass))
            || !is_subclass_of($testClass, WebTestCase::class)
            || strpos($testClass, 'FeatureTest') === false
            || strpos($testClass, 'App\Tests\Functional') === false
        ) {
            return false;
        }

        return true;
    }

    public function getTestFiles(string $testRoot): array
    {
        $path = $testRoot . DIRECTORY_SEPARATOR . 'Functional';
        return array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);
    }

    public function getMessage(string $filePath): string
    {
        return "This is not a functional test in file: $filePath";
    }
}
