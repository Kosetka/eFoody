<?php

/**
 * Company class
 */
class Test
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $this->view('test', $data);
    }
    public function wa()
    {
        //if (empty($_SESSION['USER']))
        //    redirect('login');

        $data = [];

        $this->view('test.wa', $data);
    }

}
