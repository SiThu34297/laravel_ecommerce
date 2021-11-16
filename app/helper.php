<?php
    function presentPrice($price)
    {
        return '$' . number_format($price / 100, 2, '.', '');
    }
