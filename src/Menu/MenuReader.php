<?php declare(strict_types = 1);

namespace MyProject\Menu;

interface MenuReader {
  public function readMenu() : array;
}
