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

abstract class AbstractLocationClassTestValidator extends AbstractLocationTestValidator
{
    protected function getClassName($filePath)
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
        return !empty($namespace) ? "{$namespace}\\{$classParts[1]}" : $classParts[1];
    }
}