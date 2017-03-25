<?php declare(strict_types = 1);

/*
 * Adapter for Mustache_Engine class
 * SOLID -> Interface-Segregation Principle
 */

namespace MyProject\Template;

use Mustache_Engine;

class MustacheRenderer implements Renderer {
  private $engine;

  public function __construct(Mustache_Engine $engine) {
    $this->engine = $engine;
  }

  public function render($template, $data = []) : string {
    return $this->engine->render($template, $data);
  }
}
