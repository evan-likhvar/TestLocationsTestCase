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



abstract class AbstractLocationTestValidator implements TestTypeValidatorInterface
{

    const TEST_TYPE = 'Abstract';

    abstract public function isValid(string $filePath);

    public function getTestFiles(string $testRoot): array
    {
        $path = $testRoot . DIRECTORY_SEPARATOR . self::TEST_TYPE;
        return array_diff(glob($path . DIRECTORY_SEPARATOR . '*'), ['..', '.']);
    }

    public function getMessage(string $filePath): string
    {
        return "This is not a " . self::TEST_TYPE . " test in file: $filePath";
    }
}
