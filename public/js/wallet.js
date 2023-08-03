$('#walltetList li a').click(function (e) {
    wallet = $(this).attr('wallet');
    if (wallet == 'privatekey') {
        $('#walletPrivateKey').show()
    } else {
        $('#walletPrivateKey').hide()
    }
    $('#selectedWallet').html($(this).html());
    $('#mainWalletList').prop("checked", false);
});

function connectWallet() {
    $('.walletconnect-btn').hide();
    $('.connectLoading-btn').show();
    switch (wallet) {
        case 'rabet':
            rabbetWallet();
            break;
        case 'frighter':
            frighterWallet();
            break;
        case 'ledger':
            break;
        case 'albeto':
            albedoWallet();
            break;
        case 'xbull':
            xbullWallet();
            break;
        case 'privatekey':
            storePublic($('#walletPrivateKey').val())
            break;
        default:
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
            toastr.warning('Please select Wallet', 'Selection');
    }
}

function rabbetWallet() {
    if (!window.rabet) {
        toastr.error('Please install Rabet Extension!', 'Rabbet Wallet');
        $('.walletconnect-btn').show();
        $('.connectLoading-btn').hide();
    }
    rabet.connect()
        .then(function (result) {
            storeWalletPublic(result.publicKey, 'rabet');
        })
        .catch(function (error) {
            toastr.error(`Wallet Connection Rejected!`, 'Rabbet Wallet');
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        });
}

function xbullWallet() {
    if (typeof xBullSDK == "undefined") {
        toastr.error('Please install Xbull Extension!', 'Xbull Wallet');
        $('.walletconnect-btn').show();
        $('.connectLoading-btn').hide();
    }
    xBullSDK.connect({
        canRequestPublicKey: true,
        canRequestSign: true
    }).then(function () {
        xBullSDK.getPublicKey().then(function (key) {
            storeWalletPublic(key, 'xbull');
        })
    })
        .catch(function (error) {
            toastr.error(`Error Occured`, 'Xbull Wallet');
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        });
}

function albedoWallet() {
    albedo.publicKey()
        .then(function (res) {
            console.log(res.pubkey, res.signed_message, res.signature);
            storeWalletPublic(res.pubkey, 'albeto');
        })
        .catch(function (error) {
            toastr.error(`Connection Rejected`, 'Albedo Wallet');
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        });
}

const frighterPublicKey = async () => {
    let publicKey = "";
    let error = "";

    try {
        publicKey = await window.freighterApi.getPublicKey();
    } catch (e) {
        error = e;
    }

    if (error) {
        return error;
    }

    return publicKey;
};

function frighterWallet() {
    try {
        window.freighterApi.isConnected();
    } catch (error) {
        toastr.error('Please install Frighter Extension!', 'Frighter Wallet');
        $('.walletconnect-btn').show();
        $('.connectLoading-btn').hide();
    }
    frighterPublicKey()
        .then(function (publicKey) {
            if (publicKey != 'User declined access') {
                storeWalletPublic(publicKey, 'frighter');
            } else {
                toastr.error(publicKey, 'Frighter Wallet');
                $('.walletconnect-btn').show();
                $('.connectLoading-btn').hide();
            }
        })
        .catch(function (error) {
            toastr.error(`Error Occured`, 'Frighter Wallet');
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        });
}

function kFormatter(num) {
    return Math.abs(num) > 999 ? Math.sign(num) * ((Math.abs(num) / 1000).toFixed(1)) : Math.sign(num) * Math.abs(num)
}

function number_format_short(n) {
    var n_format = 0;
    var suffix = '';
    if (n < 900) {
        // 0 - 900
        n_format = (n);
        suffix = '';
    } else if (n < 900000) {
        // 0.9k-850k
        n_format = (n / 1000);
        suffix = 'K';
    } else if (n < 900000000) {
        // 0.9m-850m
        n_format = (n / 1000000);
        suffix = 'M';
    } else if (n < 900000000000) {
        // 0.9b-850b
        n_format = (n / 1000000000);
        suffix = 'B';
    } else {
        // 0.9t+
        n_format = (n / 1000000000000);
        suffix = 'T';
    }
    return Math.floor(n_format).toString() + suffix;
}

function storeWalletPublic(public, wallet) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url + '/wallet/store',
        type: "post",
        data: {
            public: public,
            wallet: wallet
        },
        success: function (response) {
            if (response.status == 1) {
                location.reload();
                $('#slider_single').val(10);
                $('.range-value').css('left', 'calc(0% + 10px)');
                $('.range-value').html('<span>10k</span>');

                if (response.lowAmount) {
                    $('#create-dao').attr('disabled', true);
                    $('#slider_single').attr('disabled', true);
                    $('#eligibleError').removeAttr('hidden');
                    $('.rangeP').text('Below 10k');
                    $('#maxRange').text('Below 10k');
                } else {
                    $('#create-dao').removeAttr('disabled');
                    $('#slider_single').removeAttr('disabled');
                    $('#eligibleError').attr('hidden', true);
                    // var accVal = Math.round((parseInt((response.balance).replace(/,/g, '')) / 1000));
                    var accVal = kFormatter(parseInt((response.balance).replace(/,/g, '')));
                    $('#slider_single').attr('max', Math.floor(accVal));
                    $('.rangeP').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))));
                    $('#maxRange').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))) + ' token');
                }
                $('.remove-btn').show();

                $('#topWallet').text((response.public).substring(0, 4) + '...' + (response.public).slice(-5));
                $('#accountBalance').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))));
                $('#walletImage').attr('src', base_url + '/images/' + wallet + '.png');

                toastr.success('Wallet Successfully Conneceted', 'Wallet Connection')
                $('.walletconnect-btn').show();
                $('.connectLoading-btn').hide();
                $('#ConnectWallet').modal('hide');
            } else {
                toastr.error(`Error: ${response.msg}`, 'Connection')
                $('.walletconnect-btn').show();
                $('.connectLoading-btn').hide();
            }
        },
        error: function (xhr, status, error) {
            toastr.error("Deposit 5 XLM lumens into your wallet", "Wallet Error");
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        }
    });
}

function storePublic(key) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url + '/wallet/secret',
        type: "post",
        data: {
            key: key,
        },
        success: function (response) {
            if (response.status == 1) {
                $('#topWallet').text((response.public).substring(0, 4) + '...' + (response.public).slice(-5));
                $('#accountBalance').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))));

                $('#slider_single').val(10);
                $('.range-value').css('left', 'calc(0% + 10px)');
                $('.range-value').html('<span>10k</span>');

                if (response.lowAmount) {
                    $('#create-dao').attr('disabled', true);
                    $('#slider_single').attr('disabled', true);
                    $('#eligibleError').removeAttr('hidden');
                    $('.rangeP').text('Below 10k');
                    $('#maxRange').text('Below 10k');
                } else {
                    $('#create-dao').removeAttr('disabled');
                    $('#slider_single').removeAttr('disabled');
                    $('#eligibleError').attr('hidden', true);
                    // var accVal = Math.round((parseInt((response.balance).replace(/,/g, '')) / 1000));
                    var accVal = kFormatter(parseInt((response.balance).replace(/,/g, '')));
                    $('#slider_single').attr('max', Math.floor(accVal));
                    $('.rangeP').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))));
                    $('#maxRange').text(number_format_short(parseInt((response.balance).replace(/,/g, ''))) + ' token');
                }
                $('.remove-btn').show();


                $('#walletImage').attr('src', base_url + '/images/' + wallet + '.png');

                toastr.success('Wallet Successfully Conneceted', 'Wallet Connection')
                $('.walletconnect-btn').show();
                $('.connectLoading-btn').hide();
                $('#ConnectWallet').modal('hide');
            } else {
                toastr.error(`Error: ${response.msg}`, 'Connection')
                $('.walletconnect-btn').show();
                $('.connectLoading-btn').hide();
            }
        },
        error: function (xhr, status, error) {
            toastr.error("Deposit 5 XLM lumens into your wallet", "Wallet Error");
            $('.walletconnect-btn').show();
            $('.connectLoading-btn').hide();
        }
    });
}

function btnLoaderHide() {
    $('#create-dao').show();
    $('#loadStaking').hide();
}

$('#create-dao').click(() => {
    let validate = $('#required-tokens').val() ? true : false;
    $('.wallet-name.active').each(function(){
        $(this).val() || (validate = false);
    })
    if (validate) {
        $('#create-dao').hide();
        $('#loadStaking').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: base_url + '/wallet/invest',
            type: "post",
            data: {
                amount: 0.0001,
            },
            success: function (response) {
                if (response.status == 1) {
                    signXdr(response.xdr, response.staking_id);
                } else {
                    btnLoaderHide();
                    toastr.error(response.msg, "DAO Creating Error");
                }
            },
            error: function (xhr, status, error) {
                btnLoaderHide();
                toastr.error('Something went wrong!', "DAO Creating Error");
            }
        });
    } else {
        toastr.warning('Please fill the form');
    }
});

function signXdr(xdr, staking_id) {
    switch (wallet) {
        case 'rabet':
            rabet.sign(xdr, testnet ? 'testnet' : 'mainnet')
                .then(function (result) {
                    const xdr = result.xdr;
                    submitStakingXdr(xdr, staking_id);
                }).catch(function (error) {
                    btnLoaderHide();
                    toastr.error('Rejected!', "Rabbet Wallet");
                });
            break;

        case 'frighter':
            window.freighterApi.signTransaction(xdr, testnet ? 'TESTNET' : 'PUBLIC').then(function (result) {
                const xdr = result;
                submitStakingXdr(xdr, staking_id);
            }).catch(function (error) {
                btnLoaderHide();
                toastr.error('Rejected!', "Freighter Wallet");
            });
            break;

        case 'albeto':
            albedo.tx({
                xdr: xdr,
                network: testnet ? 'testnet' : 'mainnet'
            })
                .then(function (result) {
                    const xdr = result.signed_envelope_xdr;
                    submitStakingXdr(xdr, staking_id);
                }).catch(function (error) {
                    btnLoaderHide();
                    toastr.error('Rejected!', "Albeto Wallet");
                });

            break;
        case 'xbull':
            xBullSDK.signXDR(xdr).then(function (result) {
                const xdr = result;
                submitStakingXdr(xdr, staking_id);
            }).catch(function (error) {
                btnLoaderHide();
                toastr.error('Rejected!', "xBull Wallet");
            });
            break;
        default:
            submitStakingXdr(xdr, staking_id);
    }
}

function submitStakingXdr(xdr, staking_id) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: base_url + '/wallet/submitXdr',
        type: "post",
        data: {
            xdr: xdr,
            staking_id: staking_id
        },
        success: function (response) {
            console.log(response);
            if (response.status == 1) {
                createDao();
            } else {
                toastr.error(response.msg, "DAO Creating Error");
            }
            btnLoaderHide();
        },
        error: function (xhr, status, error) {
            console.log(xhr.responseText);
            btnLoaderHide();
            toastr.error('Something went wrong!', "DAO Creating Error");
        }
    });
}

const createDao = () => {
    let project = $('#dao-project').html();
    let asset = $('#dao-asset').html();
    let logo = $('#dao-logo').attr('src');
    let accounts = [];
    let wallets_checkbox = '.approved-wallets input[type=checkbox]';
    $(wallets_checkbox).each(function () {
        accounts.push(this.value);
    });
    let description = $('#dao-description').val();
    let domain = $('#dao-domain').html();
    let holders = $('#dao-holders').html();
    let required_tokens = $('#required-tokens').val();
    let approved_wallets = {};
    $(wallets_checkbox + ':checked').each(function (key) {
        let index = $(`.wallet-name:eq(${key + 1})`).val();
        approved_wallets[index] = this.value;
    });
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: '/dao/store',
        type: "post",
        data: { project, asset, logo, accounts, description, domain, holders, required_tokens, 'approved_wallets': JSON.stringify(approved_wallets) },
        success: function (response) {
            if (response.status == 1) {
                toastr.success(response.msg)
            }
        },
        error: function (xhr, status, error) {
            toastr.error('Something went wrong!', "DAO Creating Error");
        }
    });
}
