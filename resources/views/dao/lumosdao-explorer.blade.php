@extends('layouts.app')
@section('content')
<section>
    <div class="container">
        <div class="Platfarm-stats_title text-center mt-5">
            <div class="heading">LumenDAO Explorer</div>
        </div>
        <div class="h-65">
            <div class="explorer_card h-auto px-3 px-sm-4 pt-4 pb-4">
                <div style='width:100%' id='tx_info'>
                    <center style='margin:20px'>Loading records..</center>
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
    let tx_page_segment = 10;
    let txInfo = []
    let tx_page = 1;
    
    const setUp = async () => {
        //get all the tx
        txInfo = await getTx()
        //modify the getTx
        let j = []
        for(let i=txInfo.length-1; i> -1;i--){
            const t = JSON.parse(txInfo[i])
            if(t.action.toLowerCase().indexOf('joined dao') > -1) {
                if(!j.includes(t.signer)) {
                    //first
                    t.action = 'Joined LumosDao'
                    txInfo.splice(i+1, 0, JSON.stringify(t));
                    j.push(t.signer)
                }
            }
        }
        
        loadTxInfo()
            //configure the buttons
            E('next_tx_info').onclick = () => {
                if(tx_page < txInfo.length / tx_page_segment){
                  loadTxInfo(tx_page + 1)
                  tx_page++
                }
            }
            E('pre_tx_info').onclick = () => {
                if(tx_page > 1){
                  loadTxInfo(tx_page - 1)
                  tx_page--
                }
            }
        
    }
    
    const loadTxInfo = (page = 1) => {
            //to do pagination, segment is 10
            const start_index = (page - 1) * tx_page_segment;
            const end_index = start_index +  tx_page_segment
            //reset view
            E('tx_info').innerHTML = ""
            for(let i=start_index; i<end_index && i < txInfo.length;i++) { 
                E('tx_info').appendChild(drawExp({
                    address:JSON.parse(txInfo[i]).signer,
                    action:JSON.parse(txInfo[i]).action,
                    date:(new Date(JSON.parse(txInfo[i]).date)).toLocaleString(),
                    link:""
                }))
            }
            
            if(end_index >= txInfo.length) {
                //hide next button
                E('next_tx_info').style.display = 'none'
            }
            else {
                E('next_tx_info').style.display = 'block'
            }
            if(start_index == 0) {
                //hide next button
                E('pre_tx_info').style.display = 'none'
            }
            else {
                E('pre_tx_info').style.display = 'block'
            }
            //handle empty txs
            if(E('tx_info').firstElementChild == null) {
                //show empty view
                E('tx_info').innerHTML = `<center style="margin:50px;">No records yet</center>`
            }
            
        }
    const drawExp = (params = {}) => {
        let tm = `<div
                    class="form-control border-0 h-auto px-sm-4 py-2 d-flex flex-column flex-md-row align-items-start align-items-sm-start  justify-content-between w-100">
                    <p class="Explorer_p my-auto">${params.address.substring(0, 5) + "....." + params.address.substring(params.address.length - 5)} <a
                            class="Explorer_p_a" h ref="${params.link}"><span class="">${params.action}</span></a> </p>
                    <p class="Explorer_span d-block">${params.date}</p>
                </div>`
        let th = document.createElement('div')
        th.innerHTML = tm
        return th.firstElementChild
    }
    
    setUp()
</script>
@endsection