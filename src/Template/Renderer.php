<?php declare(strict_types = 1);

namespace MyProject\Template;

interface Renderer {
  public function render($template, $data = []) : string;
}
