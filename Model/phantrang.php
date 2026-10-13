<?php
class PhanTrang {
    public $tongSoTrang;
    public $trangHienTai;
    public $soItemMoiTrang;

    public function __construct($tongItem, $soItemMoiTrang, $trangHienTai) {
        $this->soItemMoiTrang = $soItemMoiTrang;
        $this->tongSoTrang = ceil($tongItem / $soItemMoiTrang);
        $this->trangHienTai = max(1, min($trangHienTai, $this->tongSoTrang));
    }

    public function render($url) {
        if ($this->tongSoTrang <= 1) return '';

        $html = '<nav><ul class="pagination justify-content-center">';

        // Previous
        if ($this->trangHienTai > 1) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $url . '&page=' . ($this->trangHienTai - 1) . '">«</a></li>';
        }

        // Pages
        for ($i = 1; $i <= $this->tongSoTrang; $i++) {
            $active = ($i == $this->trangHienTai) ? 'active' : '';
            $html .= '<li class="page-item ' . $active . '"><a class="page-link" href="' . $url . '&page=' . $i . '">' . $i . '</a></li>';
        }

        // Next
        if ($this->trangHienTai < $this->tongSoTrang) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $url . '&page=' . ($this->trangHienTai + 1) . '">»</a></li>';
        }

        $html .= '</ul></nav>';
        return $html;
    }
}
?>