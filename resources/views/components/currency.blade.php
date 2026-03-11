<?php

/**
 * Currency formatting component for Indonesian Rupiah
 *
 * Usage: <x-currency :value="10000" />
 */
?>

<span>{{ $prefix ?? 'Rp' }} {{ number_format($value ?? 0, 0, ',', '.') }}</span>
