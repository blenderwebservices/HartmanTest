<?php
require __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Str;

$content = 'Fórmula: $S = \{x | x \in C\}$';
echo "Original: $content\n";
echo "Markdown: " . Str::markdown($content) . "\n";

$content2 = 'Fórmula: $S = \\{x | x \\in C\\}$';
echo "Original 2 (escaped backslashes): $content2\n";
echo "Markdown 2: " . Str::markdown($content2) . "\n";
