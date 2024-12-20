<?php

use AdamWathan\Form\FormBuilder;

class FormBuilderTest extends TestCase
{
    /**
     * @var FormBuilder
     */
    protected $form;

    protected function _setUp()
    {
        $this->form = new FormBuilder();
    }

    protected function _tearDown()
    {
        Mockery::close();
    }

    public function testFormBuilderCanBeCreated()
    {
        $formBuilder = new FormBuilder();
        $this->assertInstanceOf('AdamWathan\Form\FormBuilder', $formBuilder);
    }

    public function testFormOpen()
    {
        $expected = '<form method="POST" action="">';
        $result = (string) $this->form->open();
        $this->assertEquals($expected, $result);
    }

    public function testCanCloseForm()
    {
        $expected = '</form>';
        $result = (string) $this->form->close();
        $this->assertEquals($expected, $result);
    }

    public function testTextBox()
    {
        $expected = '<input type="text" name="email">';
        $result = (string) $this->form->text('email');
        $this->assertEquals($expected, $result);

        $expected = '<input type="text" name="first_name">';
        $result = (string) $this->form->text('first_name');
        $this->assertEquals($expected, $result);
    }

    public function testPassword()
    {
        $expected = '<input type="password" name="password">';
        $result = (string) $this->form->password('password');
        $this->assertEquals($expected, $result);

        $expected = '<input type="password" name="password_confirmed">';
        $result = (string) $this->form->password('password_confirmed');
        $this->assertEquals($expected, $result);
    }

    public function testCheckbox()
    {
        $expected = '<input type="checkbox" name="terms" value="1">';
        $result = (string) $this->form->checkbox('terms');
        $this->assertEquals($expected, $result);

        $expected = '<input type="checkbox" name="terms" value="agree">';
        $result = (string) $this->form->checkbox('terms', 'agree');
        $this->assertEquals($expected, $result);

        $expected = '<input type="checkbox" name="terms" value="agree">';
        $result = (string) $this->form->checkbox('terms')->value('agree');
        $this->assertEquals($expected, $result);
    }

    public function testRadio()
    {
        $expected = '<input type="radio" name="terms" value="terms">';
        $result = (string) $this->form->radio('terms');
        $this->assertEquals($expected, $result);

        $expected = '<input type="radio" name="terms" value="agree">';
        $result = (string) $this->form->radio('terms', 'agree');
        $this->assertEquals($expected, $result);

        $expected = '<input type="radio" name="terms" value="agree">';
        $result = (string) $this->form->radio('terms')->value('agree');
        $this->assertEquals($expected, $result);
    }

    public function testSubmit()
    {
        $expected = '<button type="submit">Sign In</button>';
        $result = (string) $this->form->submit('Sign In');
        $this->assertEquals($expected, $result);
    }

    public function testReset()
    {
        $expected = '<button type="reset">Reset</button>';
        $result = (string) $this->form->reset('Reset');
        $this->assertEquals($expected, $result);
    }

    /**
     * @dataProvider buttonProvider
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('buttonProvider')]
    public function testButton($value, $name, $expected)
    {
        $result = (string) $this->form->button($value, $name);
        $this->assertEquals($expected, $result);
    }

    public static function buttonProvider()
    {
        return [
            ['Click Me', 'click-me', '<button type="button" name="click-me">Click Me</button>'],
            ['Click Me', null, '<button type="button">Click Me</button>'],
        ];
    }

    public function testSelect()
    {
        $expected = '<select name="color"><option value="red">Red</option><option value="blue">Blue</option></select>';
        $result = (string) $this->form->select('color', ['red' => 'Red', 'blue' => 'Blue']);
        $this->assertEquals($expected, $result);

        $expected = '<select name="fruit"><option value="apple">Granny Smith</option><option value="berry">Blueberry</option></select>';
        $result = (string) $this->form->select('fruit', ['apple' => 'Granny Smith', 'berry' => 'Blueberry']);
        $this->assertEquals($expected, $result);
    }

    public function testTextArea()
    {
        $expected = '<textarea name="bio" rows="10" cols="50"></textarea>';
        $result = (string) $this->form->textarea('bio');
        $this->assertEquals($expected, $result);

        $expected = '<textarea name="description" rows="10" cols="50"></textarea>';
        $result = (string) $this->form->textarea('description');
        $this->assertEquals($expected, $result);
    }

    public function testLabel()
    {
        $expected = '<label>Email</label>';
        $result = (string) $this->form->label('Email');
        $this->assertEquals($expected, $result);

        $expected = '<label>First Name</label>';
        $result = (string) $this->form->label('First Name');
        $this->assertEquals($expected, $result);
    }

    public function testRenderCheckboxAgainstBinaryZero()
    {
        $expected = '<input type="checkbox" name="boolean" value="0">';
        $result = (string) $this->form->checkbox('boolean', 0);
        $this->assertEquals($expected, $result);
    }

    public function testRenderRadioAgainstBinaryZero()
    {
        $expected = '<input type="radio" name="boolean" value="0">';
        $result = (string) $this->form->radio('boolean', 0);
        $this->assertEquals($expected, $result);
    }

    public function testNoErrorStoreReturnsNull()
    {
        $expected = '';
        $result = (string) $this->form->getError('email');
        $this->assertEquals($expected, $result);
    }

    public function testCanCheckForErrorMessage()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->with('email')->andReturn(true);

        $this->form->setErrorStore($errorStore);

        $result = $this->form->hasError('email');
        $this->assertTrue($result);

        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->with('email')->andReturn(false);

        $this->form->setErrorStore($errorStore);

        $result = $this->form->hasError('email');
        $this->assertFalse($result);
    }

    public function testCanRetrieveErrorMessage()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->with('email')->andReturn('The e-mail address is invalid.');

        $this->form->setErrorStore($errorStore);

        $expected = 'The e-mail address is invalid.';
        $result = $this->form->getError('email');
        $this->assertEquals($expected, $result);
    }

    public function testCanRetrieveFormattedErrorMessage()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->andReturn(true);
        $errorStore->shouldReceive('getError')->with('email')->andReturn('The e-mail address is invalid.');

        $this->form->setErrorStore($errorStore);

        $expected = '<span class="error">The e-mail address is invalid.</span>';
        $result = $this->form->getError('email', '<span class="error">:message</span>');
        $this->assertEquals($expected, $result);
    }

    public function testFormattedErrorMessageReturnsNothingIfNoError()
    {
        $errorStore = Mockery::mock('AdamWathan\Form\ErrorStore\ErrorStoreInterface');
        $errorStore->shouldReceive('hasError')->with('email')->andReturn(false);

        $this->form->setErrorStore($errorStore);

        $expected = '';
        $result = $this->form->getError('email', '<span class="error">:message</span>');
        $this->assertEquals($expected, $result);
    }

    public function testHidden()
    {
        $expected = '<input type="hidden" name="secret">';
        $result = (string) $this->form->hidden('secret');
        $this->assertEquals($expected, $result);

        $expected = '<input type="hidden" name="token">';
        $result = (string) $this->form->hidden('token');
        $this->assertEquals($expected, $result);
    }

    public function testFile()
    {
        $expected = '<input type="file" name="photo">';
        $result = (string) $this->form->file('photo');
        $this->assertEquals($expected, $result);

        $expected = '<input type="file" name="document">';
        $result = (string) $this->form->file('document');
        $this->assertEquals($expected, $result);
    }

    public function testEmail()
    {
        $expected = '<input type="email" name="email">';
        $result = (string) $this->form->email('email');
        $this->assertEquals($expected, $result);

        $expected = '<input type="email" name="alternate_email">';
        $result = (string) $this->form->email('alternate_email');
        $this->assertEquals($expected, $result);
    }

    public function testCanSetCsrfToken()
    {
        $this->form->setToken('12345');
        $refProp = new ReflectionProperty($this->form, 'csrfToken');
        $refProp->setAccessible(true);
        $this->assertEquals('12345', $refProp->getValue($this->form));
        $refProp->setAccessible(false);
    }

    public function testCanRenderCsrfToken()
    {
        $this->form->setToken('12345');

        $expected = '<input type="hidden" name="_token" value="12345">';
        $result = (string) $this->form->token();
        $this->assertEquals($expected, $result);
    }

    public function testTokenIsRenderedAutomaticallyOnOpenIfSet()
    {
        $this->form->setToken('12345');

        $expected = '<form method="POST" action=""><input type="hidden" name="_token" value="12345">';
        $result = (string) $this->form->open();
        $this->assertEquals($expected, $result);
    }

    public function testTokenIsNotRenderedAutomaticallyOnOpenFormWithGetMethodIfSet()
    {
        $this->form->setToken('12345');

        $expected = '<form method="GET" action="">';
        $result = (string) $this->form->open()->get();
        $this->assertEquals($expected, $result);
    }

    public function testRemoveClass()
    {
        $expected = '<input type="text" name="food">';
        $result = (string) $this->form->text('food')->addClass('sandwich pizza')->removeClass('sandwich')->removeClass('pizza');
        $this->assertEquals($expected, $result);
    }

    public function testGetTypeAttribute()
    {
        $expected = 'radio';
        $result = $this->form->radio('fm-transmission')->getAttribute('type');
        $this->assertEquals($expected, $result);
    }

    public function testAgainstXSSAttacksInAttributes()
    {
        $expected = '<input type="text" name="meme" lol="catz&quot;&gt;&lt;script&gt;alert(&quot;xss&quot;)&lt;/script&gt;">';
        $result = $this->form->text('meme')->lol('catz"><script>alert("xss")</script>');
        $this->assertEquals($expected, $result);
    }
}
