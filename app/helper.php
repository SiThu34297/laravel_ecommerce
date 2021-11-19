<?php
    function presentPrice($price)
    {
        return '$' . number_format($price / 100, 2, '.', '');
    }

    function productImage($path)
    {
        return $path && file_exists('storage/'.$path) ? asset('storage/'.$path) : asset('images/products/image-not-available.png');
    }
