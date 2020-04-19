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

class BehaviorTestValidator implements TestTypeValidatorInterface
{

    public function isValid(string $filePath, string $testClass)
    {
        if (!is_file($filePath) || strpos($filePath, 'BehaviorTest') === false) {
            return false;
        }

        $parts = pathinfo($filePath);

        return $parts['extension'] === 'feature';
    }

    public function getTestFiles(string $testRoot): array
    {
        $path = $testRoot . DIRECTORY_SEPARATOR . 'Behavior';
        return array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);
    }

    public function getMessage(string $filePath): string
    {
        return "This is not a behavior test in file: $filePath";
    }
}
