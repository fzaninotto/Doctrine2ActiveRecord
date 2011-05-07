<?php

namespace Propel\Util;

class ArrayType
{
    /**
     * Stringify an array
     *
     * Based on Symfony\Component\DependencyInjection\Dumper\PhpDumper::exportParameters
     * http://github.com/symfony/symfony and sweetly tweaked by Brikou CARRÉ
     *
     * @param  array   $array       The array
     * @param  integer $indentation The indentation
     *
     * @return string  The array stringified
     */
    static public function stringify(array $array, $indentation = 16)
    {
        $count = count($array);
        $isAssociative = array_keys($array) !== range(0, $count - 1);

        if ($count > 1 && $isAssociative) {
            $length = array_reduce(array_keys($array), function($length, $key) {
                return max(array($length, strlen(var_export($key, true))));
            });
        }

        $lines = array();

        foreach ($array as $key => $value) {

            if (is_array($value)) {
                if ($count > 1) {
                    $value = self::stringify($value, $indentation + 4);
                } else {
                    $value = self::stringify($value, $indentation);
                }
            } else {
                $value = var_export($value, true);
            }

            if ($count > 1) {
                if ($isAssociative) {
                    $lines[] = sprintf('%s%-' . $length . 's => %s,', str_repeat(' ', $indentation), var_export($key, true), $value);
                } else {
                    $lines[] = sprintf('%s%s,', str_repeat(' ', $indentation), $value);
                }
            } else {
                if ($isAssociative) {
                    $lines[] = sprintf('%s => %s', var_export($key, true), $value);
                } else {
                    $lines[] = sprintf('%s', $value);
                }
            }
        }

        if ($count > 1) {
            return sprintf('array('. PHP_EOL . '%s'. PHP_EOL . '%s)', implode(PHP_EOL, $lines), str_repeat(' ', $indentation - 4));
        } else if ($count === 1) {
            return sprintf('array(%s)', $lines[0]);
        } else {
            return 'array()';
        }
    }
}
