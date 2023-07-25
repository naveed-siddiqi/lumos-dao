$(document).ready(function(){
    let wallets_checkbox = '.approved-wallets input[type=checkbox]';
    $(wallets_checkbox).click(function(){
        let wallet_name = $(this).closest('.form-group').find('.wallet-name');
        this.checked ? wallet_name.toggleClass('d-none active') : wallet_name.toggleClass('d-none active');
    });

    $('#create-dao').click(() => {
        let validate = $('#required-tokens').val() ? true : false;
        $('.wallet-name.active').each(function(){
            $(this).val() || (validate = false);
        })
        if (validate) {
            let project = $('#dao-project').html();
            let asset = $('#dao-asset').html();
            let logo = $('#dao-logo').attr('src');
            let accounts = [];
            $(wallets_checkbox).each(function(){
                accounts.push(this.value);
            });
            let description = $('#dao-description').val();
            let domain = $('#dao-domain').html();
            let holders = $('#dao-holders').html();
            let approved_wallets = {};
            $(wallets_checkbox+':checked').each(function(key){
                let index = $(`.wallet-name:eq(${key+1})`).val();
                approved_wallets[index] = this.value;
            });
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/dao/store',
                type: "post",
                data: {project, asset, logo, accounts, description, domain, holders, 'approved_wallets':JSON.stringify(approved_wallets)},
                success: function (response) {
                    toastr.success('Success')
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    toastr.error('Something went wrong!', "DAO Creating Error");
                }
            });
        } else {
            toastr.warning('Please fill the form');
        }
    })
});

async function copy(text) {
    try {
        await navigator.clipboard.writeText(text);
    } catch (err) {
        console.error('Failed to copy: ', err);
    }
}
