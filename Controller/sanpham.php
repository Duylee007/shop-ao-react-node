<?php
require_once dirname(__DIR__) . "/Model/hanghoa.php";
require_once dirname(__DIR__) . "/Model/phantrang.php";
class SanPhamController {
    private $hh;
    public function __construct() { $this->hh = new HangHoa(); }
    public function index() {
        $page = max(1, (int)($_GET['page'] ?? 1));
        $id_loai = (int)($_GET['loai'] ?? 0);
        $keyword = trim($_GET['search'] ?? '');
        $perPage = 12;
        if (!empty($keyword)) { $sanpham = $this->hh->search($keyword); $tongItem = count($sanpham); $sanpham = array_slice($sanpham, ($page-1)*$perPage, $perPage); }
        elseif ($id_loai > 0) { $sanpham = $this->hh->getByCategory($id_loai); $tongItem = count($sanpham); $sanpham = array_slice($sanpham, ($page-1)*$perPage, $perPage); }
        else { $tongItem = $this->hh->countAll(); $sanpham = $this->hh->getByPage($page, $perPage); }
        $phantrang = new PhanTrang($tongItem, $perPage, $page);
        require_once dirname(__DIR__) . "/View/sanpham.php";
    }
    public function chiTiet() {
        $sp = $this->hh->getById((int)($_GET['id'] ?? 0));
        if (!$sp) { header("Location: index.php?act=sanpham"); exit; }
        $spLienQuan = $this->hh->getByCategory($sp['id_loai']);
        require_once dirname(__DIR__) . "/View/sanphamchitiet.php";
    }
}
$ctrl = new SanPhamController();
if (isset($_GET['act']) && $_GET['act'] == 'chitiet') $ctrl->chiTiet();
else $ctrl->index();
?>