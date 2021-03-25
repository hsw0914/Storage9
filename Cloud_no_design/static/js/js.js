jQuery(function ($) {
    $('.btn').on('click', function () {
        $('.table').slideDown(100)
        $('.btn').slideUp()
    })

    $('.close').on('click', function () {
        $('.table').slideUp(100)
        $('.btn').slideDown()
    })

    $(document).on('click', '.inset', function (e) {
        e.preventDefault();
        var link = $(this).attr('href')
        if (confirm("내부 인원에게 공유하시겠습니까?")) {
            location.href = link;
        }
    })

    var $checkAll = $('#check')
    var $checkList = $('[name = "name[]"]')
    $checkAll.on('change', function () {
        $checkList.prop('checked', this.checked)
    })

    $checkList.on('change', function () {
        var check = $checkList.length === $checkList.filter(':checked').length
        $checkAll.prop('checked', check)
    })

    var $checkAll_ = $('#check_')
    var $checkList_ = $('[name = "namee[]"]')
    $checkAll_.on('change', function () {
        $checkList_.prop('checked', this.checked)
    })
    $checkList_.on('change', function () {
        var check_ = $checkList_.length === $checkList_.filter(':checked').length
        $checkAll_.prop('checked', check_)
    })

})