<?php
require_once dirname(__DIR__) . "/Model/hanghoa.php";
class HomeController {
    private $hh;
    public function __construct() { $this->hh = new HangHoa(); }
    public function index() {
        $sanphamNoiBat = $this->hh->getFeatured(8);
        $sanphamMoi = array_slice($this->hh->getAll(), 0, 4);
        require_once dirname(__DIR__) . "/View/home.php";
    }
}
$ctrl = new HomeController(); $ctrl->index();
?>