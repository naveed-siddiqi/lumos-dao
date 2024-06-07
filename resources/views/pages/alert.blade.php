@extends('layouts.app')
@section('content')
<section>
    <div class="container">
        <div class="Platfarm-stats_title text-center mt-5">
            <div class="heading">LumenDAO Notifications</div>
        </div>
        <div style="min-height: 65vh;" class="">
            <div style="width: 100% !important;" class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 bg-white w-100" id='alert_view'>
                <!--<div style="background: var(--third-bg-light);"-->
                <!--    class="form-control relative border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">-->
                <!--    <p class="Explorer_p my-auto">Notification Title 1<a-->
                <!--            class="Explorer_p_a" h ref="${params.link}"><span class="">Notification description Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></a> </p>-->
                <!--    <div class="d-flex align-items-center justify-content-end gap-2">-->
                <!--    <p class="Explorer_span d-block">12/09/2024</p>-->
                <!--    <span style="width: 8px; height:8px; border-radius:50%;" class="bg-danger"></span>-->
                <!--    </div>-->
                <!--</div>-->
                <center style='margin:20px'>Loading records..</center>
            </div>
        </div>
    </div>
</section>
<script>
    
    const main = async () => {
        //fetch the alert
        const alerts = await getAllUserAlerts()
        if(alerts !== false) {
            //do the pagination
            paginate('alert_view', alerts, 10, drawAlert)
            //reset the alert num to zero
            E('nav_user_alert_num').innerText = 0
        }
    }
    
    
    /* DRAWS */
    const drawAlert = (param) => {
        param = JSON.parse(param)
        const view = `<div style="background: var(--third-bg-light); width: 100%; flex-grow: 1;"
                        class="form-control relative border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                        <p class="Explorer_p my-auto">${param.title} <br>
                        <a class="Explorer_p_a" href="${(window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/" ) + param.link}"><span class="">
                        ${fAddr(param.other, 8) + " " + param.action}
                        </span></a> </p>
                        <div class="d-flex align-items-center justify-content-end gap-2">
                        <p class="Explorer_span d-block">
                        ${new Date(param.date).toLocaleString()}
                        </p>
                        <span style="width: 8px; height:8px; border-radius:50%;" class="bg-danger"></span>
                        </div>
                    </div>`
        return view;
    }
    
    //run the main function
    main()
</script>
@endsection