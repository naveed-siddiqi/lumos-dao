$(document).ready(function(){
    let wallets_checkbox = '.approved-wallets input[type=checkbox]';
    $(wallets_checkbox).click(function(){
        let wallet_name = $(this).closest('.form-group').find('.wallet-name');
        this.checked ? wallet_name.toggleClass('d-none active') : wallet_name.toggleClass('d-none active');
    });

    $('#startDate').change(function() {
        let startDateValue = $(this).val();
        if (startDateValue !== '') {
            let startDate = new Date(startDateValue);
            startDate.setDate(startDate.getDate() + 5);

            // Format the end date as 'yyyy-mm-dd'
            let endDateValue = startDate.toISOString().split('T')[0];

            $('#endDate').val(endDateValue);
        }
    });
});

async function copy(text) {
    try {
        await navigator.clipboard.writeText(text);
        toastr.success('Copied!')
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}
