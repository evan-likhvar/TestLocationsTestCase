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
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Kernel;

class TestLocationsTestCase extends TestCase
{
    private $errors = [];

    private $testRoot;

    public function validateTestLocation(string $testRoot)
    {
        $this->testRoot = $testRoot;

        $unitTestFiles = [
            'Unit' => $this->getUnitTestFiles(),
            'Functional' => $this->getFunctionalTestFiles(),
            'Integration' => $this->getIntegrationTestFiles(),
            'Behavior' => $this->getBehaviorTestFiles()
        ];

        foreach ($unitTestFiles as $type => $filePaths) {
            $validateMethod = "is{$type}Test";

            foreach ($filePaths as $filePath) {
                $message = "This is not a $type test in file: $filePath";

                include_once $filePath;

                if ($this->{$validateMethod}($filePath) == $message) {
                    $this->errors[] = $message;
                }
            }
        }
        return $this->errors;
    }

    public function isUnitTest(string $filePath)
    {
        $testClass = $this->getClassName($filePath);

        if ((!is_string($testClass) && !is_object($testClass))
            || is_subclass_of($testClass, KernelTestCase::class)
            || is_subclass_of($testClass, WebTestCase::class)
            || !is_subclass_of($testClass, TestCase::class)
            || strpos($testClass, 'UnitTest') === false
            || strpos($testClass, 'App\Tests\Unit') === false
        ) {
            return false;
        }

        return true;
    }

    public function isFunctionalTest(string $filePath)
    {
        $testClass = $this->getClassName($filePath);

        if ((!is_string($testClass) && !is_object($testClass))
            || !is_subclass_of($testClass, WebTestCase::class)
            || strpos($testClass, 'FeatureTest') === false
            || strpos($testClass, 'App\Tests\Functional') === false
        ) {
            return false;
        }

        return true;
    }

    public function isIntegrationTest(string $filePath)
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

    public function isBehaviorTest(string $filePath)
    {
        if (!is_file($filePath) || strpos($filePath, 'BehaviorTest') === false) {
            return false;
        }

        $parts = pathinfo($filePath);

        return $parts['extension'] === 'feature';
    }

    public function getUnitTestFiles(): iterable
    {
        $path = $this->testRoot . DIRECTORY_SEPARATOR . 'Unit';
        $files = array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);

        return $files;
    }

    public function getFunctionalTestFiles(): iterable
    {
        $path = $this->testRoot . DIRECTORY_SEPARATOR . 'Functional';
        $files = array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);

        return $files;
    }

    public function getIntegrationTestFiles(): iterable
    {
        $path = $this->testRoot . DIRECTORY_SEPARATOR . 'Integration';
        $files = array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);

        return $files;
    }

    public function getBehaviorTestFiles(): iterable
    {
        $path = $this->testRoot . DIRECTORY_SEPARATOR . 'Behavior';
        $files = array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);

        return $files;
    }

    private function getClassName($filePath)
    {
        $file = file($filePath, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

        if (!is_array($file)) {
            return null;
        }

        foreach ($file as $line) {
            if (isset($classParts) && isset($namespaceParts)) {
                continue;
            }
            if (strpos($line, 'class') === 0) {
                preg_match('/^class\s+([a-zA-z0-9_]+)\s{0,}/', $line, $classParts);
            }
            if (strpos($line, 'namespace') === 0) {
                preg_match('/^namespace\s+(\S+)\s{0,};/', $line, $namespaceParts);
            }
        }
        $namespace = isset($namespaceParts[1]) ? $namespaceParts[1] : '';
        $className = !empty($namespace) ? "{$namespace}\\{$classParts[1]}" : $classParts[1];

        return $className;
    }
}
