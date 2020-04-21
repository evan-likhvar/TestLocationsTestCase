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

class BehaviorTestValidator extends AbstractLocationTestValidator
{
    const TEST_TYPE = 'Behavior';

    public function isValid(string $filePath)
    {
        if (!is_file($filePath) || strpos($filePath, 'BehaviorTest') === false) {
            return false;
        }

        $parts = pathinfo($filePath);

        return $parts['extension'] === 'feature';
    }
}
