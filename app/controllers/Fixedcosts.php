<?php

/**
 * Sale class
 */
class Fixedcosts
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $this->view('fixedcosts', $data);
    }

    public function new()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $this->view('fixedcosts.new', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');
        $data = [];

        $this->view('fixedcosts.edit', $data);
    }
}