<?php

use AdamWathan\Form\Elements\Button;

class ButtonTest extends TestCase
{
    public function testButtonCanBeCreated()
    {
        $submit = new Button('Click Me', 'click-me');
        $this->assertInstanceOf('AdamWathan\Form\Elements\Button', $submit);
    }

    public function testRenderBasicButton()
    {
        $button = new Button('Click Me', 'click-me');
        $expected = '<button type="button" name="click-me">Click Me</button>';
        $result = $button->render();

        $this->assertEquals($expected, $result);
    }

    public function testCanChangeValue()
    {
        $button = new Button('Button');
        $button->value('Click Me');
        $expected = '<button type="button">Click Me</button>';
        $result = $button->render();

        $this->assertEquals($expected, $result);
    }
}
