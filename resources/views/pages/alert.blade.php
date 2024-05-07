@extends('layouts.app')
@section('content')
<section>
    <div class="container">
        <div class="Platfarm-stats_title text-center mt-5">
            <div class="heading">LumenDAO Notifications</div>
        </div>
        <div style="min-height: 65vh;" class="">
            <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4 bg-white">
                 <div style="background: var(--third-bg-light);"
                    class="form-control relative border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                    <p class="Explorer_p my-auto">Notification Title 1<a
                            class="Explorer_p_a" h ref="${params.link}"><span class="">Notification description Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></a> </p>
                    <div class="d-flex align-items-center justify-content-end gap-1">
                    <p class="Explorer_span d-block">12/09/2024</p>
                    <span style="width: 8px; height:8px; border-radius:50%;" class="bg-danger"></span>
                    </div>
                </div>
                <div class='d-flex' style='flex-direction:row-reverse;width:100%'>
                    <button id='next_tx_info' class='btn' style='display:none'>Next</button>
                    <button id='pre_tx_info' class='btn' style='display:none'>Prev</button>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
</script>
@endsection