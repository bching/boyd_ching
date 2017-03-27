<?php declare(strict_types = 1);

return[
  ['GET', '/', ['MyProject\Controllers\Homepage', 'show']],
  ['GET', '/{slug}', ['MyProject\Controllers\Page', 'show']]
];
