$(document).ready(function(){
    $('.approved-wallets input[type=checkbox]').click(function(){
        let wallet_name = $(this).closest('.form-group').find('.wallet-name');
        this.checked ? wallet_name.removeClass('d-none') : wallet_name.addClass('d-none');
    });
});

async function copy(text) {
    try {
        await navigator.clipboard.writeText(text);
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}
