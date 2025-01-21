<?php

/**
 * Write code on Method
 *
 * @return response()
 */
if (! function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return '€ ' . number_format($price / 100, 2, ',', '.');
    }
}
