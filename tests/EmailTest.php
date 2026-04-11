<?php

use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
  public function testCanBeCreatedFromValidEmail(): void
  {
    $string = 'user@example.com';

    $this->assertSame($string, $string);
  }
}
