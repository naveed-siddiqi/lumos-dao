import Swal from "sweetalert2";

export const alert = (msg='Something went wrong', title='Error', type='error') => {
    Swal.fire({
        icon: (type=='error')?'error':(type=='good')?'success':(type=='info')?'info':'warning',
        title,
        text:msg
    });
}

/** This functions show a modal message
* @params {msg} String
* @params {type} String [good|fail|warn|norm]
* @return {int} ModalId
**/
export const talk = (msg = "", type = "norm", id = "", pgress=0) => {
    //config stylings
    let params = {color:"black", 'class':"talk_spin fa-solid fa-spinner"}
    if(type == "good") {params.color = "forestgreen"; params.class='fa-solid fa-check-circle'}
    else if(type == "fail") {params.color = "red"; params.class='fa-solid fa-times'}
    else if(type == "warn") {params.color = "#ffa101"; params.class='fa-solid fa-info'}
    if(id != "") {
        //performing modifications
        E(id).style.color = params.color
        E(id).style.borderColor = params.color
        E('talk_msg' + id).innerHTML = msg
        E('talk_icon' + id).classList = params.class
        E('talk_loader' + id).style.width = pgress + '%'
    }
    else {
        //generate id
        id = 'talk_' + Math.floor(Math.random() * 10000000 * Math.random())
        let div = document.createElement('div')
        div.innerHTML =  `<di><style>
        .talk_spin{animation:talk_spin 700ms infinite;}
                    @keyframes talk_spin{
                        0%{
                            transform:rotate(0deg);
                        }
                        100%{
                            transform:rotate(720deg);
                        }
                    }
            </style>
            <div style='position:fixed;top:0px;left:0px;width:100vw;height:0px;display:flex;align-items:flex-start;z-index:1500'>
                <div id='${id}' style='margin-left:auto;margin-right:20px;margin-top:40px;background:white;display:flex;overflow:hidden;
                border-radius:10px;border:1px solid ${params.color};color:${params.color};font-size:17px;box-shadow:0 0 6px 3px rgba(0,0,0,.1)'>
                <div style='padding:10px 15px;text-align:center;z-index:2'><span id='talk_icon${id}' class='${params.class}' style='margin-right:5px'></span>
                <span id='talk_msg${id}' style='margin-right:5px'>${msg}</span></div>
                <div name='loader' style='margin-left:-100%;width:100%'><div id='talk_loader${id}' style='transition:all 200ms;background:linear-gradient(to right, #FFA500, #FF4500, #FF0000); width:${pgress}%;height:100%'></div></div>
                </div></div></div>
        `
        document.body.appendChild(div.firstElementChild)
    }
    return id
}
//Remove
export const stopTalking = (_timeout, id) => {
    if(_timeout > 0) {
        //using timeout
        setTimeout(() => {document.body.removeChild(E(id).parentElement.parentElement)}, _timeout * 1000)
    }
    else {
        //not using timeout
        document.body.removeChild(E(id).parentElement.parentElement)
    }
}
