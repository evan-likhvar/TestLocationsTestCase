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


interface TestTypeValidatorInterface
{
    public function isValid(string $filePath, string $testClass);

    public function getTestFiles(string $testRoot): array;

    public function getMessage(string $filePath): string;
}
