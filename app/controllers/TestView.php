<?php

/**
 * home class
 */
class TestView
{
    use Controller;

    public function index()
    {
        $this->view('test');
    }
}
