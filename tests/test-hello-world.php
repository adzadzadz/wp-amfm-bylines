<?php
class HelloWorldTest extends WP_UnitTestCase {
    function test_hello_world() {
        $this->assertEquals('Hello, World!', 'Hello, World!');
    }
}
?>