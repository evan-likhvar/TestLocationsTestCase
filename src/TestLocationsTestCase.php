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

use PHPUnit\Framework\TestCase;

class TestLocationsTestCase extends TestCase
{
    private $errors = [];

    private $testRoot;

    /** @var TestTypeValidatorInterface */
    private $validator;

    public function validateTestLocation(string $testRoot, TestTypeValidatorInterface $validator)
    {
        $this->testRoot = $testRoot;
        $this->validator = $validator;
        $testFiles = $this->getTestFiles();

        foreach ($testFiles as $filePath) {
            $message = $this->getMessage($filePath);

            include_once $filePath;

            if (!$this->isValid($filePath)) {
                $this->errors[] = $message;
            }
        }

        return $this->errors;
    }
    private function getTestFiles(): array
    {
        return $this->validator->getTestFiles($this->testRoot);
    }

    private function isValid(string $filePath): bool
    {
        return $this->validator->isValid($filePath);
    }

    private function getMessage(string $filePath): string
    {
        return $this->validator->getMessage($filePath);
    }
}
