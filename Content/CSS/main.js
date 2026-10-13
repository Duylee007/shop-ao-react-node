// ===== Main JavaScript - YaMe Style - Shop Duy =====

$(document).ready(function() {
    // Auto-hide alerts
    setTimeout(function() {
        $('.alert').fadeOut(500);
    }, 4000);

    // Navbar shadow on scroll
    $(window).scroll(function() {
        if ($(this).scrollTop() > 30) {
            $('.yame-navbar').addClass('shadow-sm');
        } else {
            $('.yame-navbar').removeClass('shadow-sm');
        }
    });

    // Quantity buttons
    $('.quantity-btn.minus').on('click', function() {
        var input = $(this).siblings('.quantity-input');
        var val = parseInt(input.val()) || 1;
        if (val > 1) input.val(val - 1);
    });

    $('.quantity-btn.plus').on('click', function() {
        var input = $(this).siblings('.quantity-input');
        var max = parseInt(input.attr('max')) || 999;
        var val = parseInt(input.val()) || 1;
        if (val < max) input.val(val + 1);
    });

    // Swatch dot hover/click preview
    $('.swatch-dot').on('click', function() {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    // Add to cart with AJAX if form has .add-to-cart-ajax
    $('.add-to-cart-ajax').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    $('#cart-count').text(response.count);
                    showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                } else {
                    showToast('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                }
            },
            error: function() {
                // Fallback normal submit
                form.off('submit').submit();
            }
        });
    });
});

// Toast notification function with YaMe luxury style
function showToast(message, type) {
    type = type || 'success';
    var bgClass = type === 'success' ? 'bg-dark' : (type === 'error' ? 'bg-danger' : 'bg-secondary');
    var icon = type === 'success' ? '<i class="fas fa-check-circle text-success me-2"></i>' : '<i class="fas fa-info-circle me-2"></i>';
    
    var toastHtml = $(
        '<div class="toast align-items-center ' + bgClass + ' text-white border-0 position-fixed bottom-0 end-0 m-4 shadow-lg" role="alert" style="z-index: 9999; border-radius: 12px;">' +
            '<div class="d-flex p-2">' +
                '<div class="toast-body d-flex align-items-center fw-bold fs-6">' +
                    icon + message +
                '</div>' +
                '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>' +
            '</div>' +
        '</div>'
    );
    
    $('body').append(toastHtml);
    var bsToast = new bootstrap.Toast(toastHtml[0], { delay: 3000 });
    bsToast.show();
    
    toastHtml.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}
