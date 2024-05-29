<?php

/**
 * Company class
 */
class Tabs
{
    use Controller;

    public function index()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $data = [];

        $links = new Linksmodel();
        foreach ($links->getAllLinks() as $link) {
            $temp[$link->id] = (array) $link;
        }
        $hierarchy = buildHierarchy($temp);
        $data["links"] = $hierarchy;

        $this->view('tabs', $data);
    }

    public function add()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $id = $URL[2];
        }
        if(!isset($id)) {
            redirect('tabs');
        }

        $data = [];
        $data["id_link"] = $id;

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $link = new Linksmodel;
            if(!isset($_POST["l_type"])) {
                $_POST["l_type"] = 0;
                $id = NULL;
            }
            if(!isset($_POST["l_active"])) {
                $_POST["l_active"] = 0;
            }
            $que = ["l_name" => $_POST["l_name"], "l_directory" => $_POST["l_directory"], "l_icon" => $_POST["l_icon"], "l_type" => $_POST["l_type"], 
            "l_order" => $_POST["l_order"], "l_active" => $_POST["l_active"], "id_parent" => $id];
            $link->insert($que);
            $data['success'] = "Zakładka została dodana.";
        }
        

        $links = new Linksmodel();
        foreach ($links->getAllLinks() as $link) {
            $temp[$link->id] = (array) $link;
        }
        $hierarchy = buildHierarchy($temp);
        $data["links"] = $hierarchy;

        $this->view('tabs', $data);
    }

    public function edit()
    {
        if (empty($_SESSION['USER']))
            redirect('login');

        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        if(isset($URL[2])) {
            $id = $URL[2];
        }
        if(!isset($id)) {
            redirect('tabs');
        }

        $data = [];
        $data["id_link"] = $id;
        $data["id_link_edit"] = TRUE;

        
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $link = new Linksmodel;
            if(!isset($_POST["l_active"])) {
                $_POST["l_active"] = 0;
            }
            $que = ["l_name" => $_POST["l_name"], "l_directory" => $_POST["l_directory"], "l_icon" => $_POST["l_icon"], 
            "l_order" => $_POST["l_order"], "l_active" => $_POST["l_active"]];
            $link->update($id, $que);
            $data['success'] = "Edycja zakładki pomyślna.";
        }
        
        $link = new Linksmodel;
        $data["link"] = $link->getLink($id);

        $links = new Linksmodel();
        foreach ($links->getAllLinks() as $link) {
            $temp[$link->id] = (array) $link;
        }
        $hierarchy = buildHierarchy($temp);
        $data["links"] = $hierarchy;

        $this->view('tabs', $data);
    }
}
