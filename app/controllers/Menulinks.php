<?php

/**
 * GetCargo class
 */
class Menulinks
{
    use Controller;
    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $links = new Linksmodel();
        foreach ($links->getLinks() as $link) {
            $temp[$link->id] = (array) $link;
        }
        $hierarchy = buildHierarchy($temp);
        $data["links"] = $hierarchy;

        $this->view('links', $data);
    }

    
    
}
