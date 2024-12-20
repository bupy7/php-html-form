<?php

namespace AdamWathan\Form;

use AdamWathan\Form\Binding\BoundData;
use AdamWathan\Form\Elements\Button;
use AdamWathan\Form\Elements\Checkbox;
use AdamWathan\Form\Elements\Email;
use AdamWathan\Form\Elements\File;
use AdamWathan\Form\Elements\FormOpen;
use AdamWathan\Form\Elements\Hidden;
use AdamWathan\Form\Elements\Label;
use AdamWathan\Form\Elements\Password;
use AdamWathan\Form\Elements\RadioButton;
use AdamWathan\Form\Elements\Select;
use AdamWathan\Form\Elements\Text;
use AdamWathan\Form\Elements\TextArea;
use AdamWathan\Form\ErrorStore\ErrorStoreInterface;

class FormBuilder
{
    protected $errorStore;

    protected $csrfToken;

    protected $boundData;

    public function setErrorStore(ErrorStoreInterface $errorStore)
    {
        $this->errorStore = $errorStore;
    }

    public function setToken($token)
    {
        $this->csrfToken = $token;
    }

    public function open()
    {
        $open = new FormOpen();

        if ($this->hasToken()) {
            $open->token($this->csrfToken);
        }

        return $open;
    }

    protected function hasToken()
    {
        return isset($this->csrfToken);
    }

    public function close()
    {
        $this->unbindData();

        return '</form>';
    }

    public function text($name)
    {
        $text = new Text($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $text->value($value);
        }

        return $text;
    }

    public function email($name)
    {
        $email = new Email($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $email->value($value);
        }

        return $email;
    }

    public function hidden($name)
    {
        $hidden = new Hidden($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $hidden->value($value);
        }

        return $hidden;
    }

    public function textarea($name)
    {
        $textarea = new TextArea($name);

        if (!is_null($value = $this->getValueFor($name))) {
            $textarea->value($value);
        }

        return $textarea;
    }

    public function password($name)
    {
        return new Password($name);
    }

    public function checkbox($name, $value = 1)
    {
        $checkbox = new Checkbox($name, $value);

        $oldValue = $this->getValueFor($name);
        $checkbox->setOldValue($oldValue);

        return $checkbox;
    }

    public function radio($name, $value = null)
    {
        $radio = new RadioButton($name, $value);

        $oldValue = $this->getValueFor($name);
        $radio->setOldValue($oldValue);

        return $radio;
    }

    public function button($value, $name = null)
    {
        return new Button($value, $name);
    }

    public function reset($value = 'Reset')
    {
        $reset = new Button($value);
        $reset->attribute('type', 'reset');

        return $reset;
    }

    public function submit($value = 'Submit')
    {
        $submit = new Button($value);
        $submit->attribute('type', 'submit');

        return $submit;
    }

    public function select($name, $options = [])
    {
        $select = new Select($name, $options);

        $selected = $this->getValueFor($name);
        $select->select($selected);

        return $select;
    }

    public function label($label)
    {
        return new Label($label);
    }

    public function file($name)
    {
        return new File($name);
    }

    public function token()
    {
        $token = $this->hidden('_token');

        if (isset($this->csrfToken)) {
            $token->value($this->csrfToken);
        }

        return $token;
    }

    public function hasError($name)
    {
        if (! isset($this->errorStore)) {
            return false;
        }

        return $this->errorStore->hasError($name);
    }

    public function getError($name, $format = null)
    {
        if (! isset($this->errorStore)) {
            return null;
        }

        if (! $this->hasError($name)) {
            return '';
        }

        $message = $this->errorStore->getError($name);

        if ($format) {
            $message = str_replace(':message', $message, $format);
        }

        return $message;
    }

    public function bind($data)
    {
        $this->boundData = new BoundData($data);
    }

    public function getValueFor($name)
    {
        if ($this->hasBoundData()) {
            return $this->getBoundValue($name, null);
        }
        return null;
    }

    protected function hasBoundData()
    {
        return isset($this->boundData);
    }

    protected function getBoundValue($name, $default)
    {
        return $this->boundData->get($name, $default);
    }

    protected function unbindData()
    {
        $this->boundData = null;
    }
}
