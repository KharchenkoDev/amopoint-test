(function ($) {
    $(function () {
        const $select = $('select[name="type_val"]');
        const $selectRow = $select.closest('p');

        function applyFilter() {
            const val = $select.val();
            $('p').not($selectRow).hide();
            $('[name*="' + val + '"]').not($select).closest('p').show();
        }

        $select.on('change', applyFilter);
        applyFilter();
    });
}(jQuery));
