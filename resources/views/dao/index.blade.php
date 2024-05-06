@extends('layouts.app')

@section('content')
<?php
    //load the dao meta funtion to avoid lag in frontend
    $path = substr(__FILE__, 0, strpos(__FILE__, 'storage'));
    require("$path.well-known/config.php");
    require("$path.well-known/db.php");
    if(isset($_COOKIE['public'])){
        $user = $_COOKIE['public'];
        $res = array(); $res['status'] = false;
        $query = "SELECT * FROM daos WHERE token = '$dao_id' ORDER BY ID DESC";
        $result = mysqli_query($conn, $query);
        if(mysqli_num_rows($result)>0){
            while($row= mysqli_fetch_array($result)){
                $res = $row;
                $res['joined'] = (strpos($row['users'], $user) > -1);
                $res['members'] = sizeof(explode(",", $row['users'])) - 1;
            }
	    $res['status'] = true;
        }
	    
    }
?>
<!-- Oauth Socials Links -->

<!-- for telegram -->
<script async onload='setUpTelegram()' src="https://telegram.org/js/telegram-widget.js?22" data-telegram-login="lumosdao_bot" data-size="medium" data-userpic="false" data-onauth="saveSocials('telegram',user)" data-request-access="write"></script>
<script type="text/javascript">
    const setUpTelegram = () => { 
        const _iframes = document.getElementsByTagName('iframe'); 
        window.telegram = null
        // Loop through all <iframe> elements
        for (var i = 0; i < _iframes.length; i++) {
            if(_iframes[i].id.indexOf('telegram') > -1){  
                window.telegram = _iframes[i];
                document.body.removeChild(window.telegram)
                break; 
            }
        }
    }
</script>

<section class="leadingBoard">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading-board">
                    <a class="headingBoard" href="{{ route('explore') }}">Explore</a>
                    <span class="rightArrow"> > </span>
                    <p id='dao_name_head' class="apple-text">
                        <?php if($res['status']){echo $res['name'];} ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="main-card-link">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card-join w-100">
                    <div style="display:none;" class="lblJoin">
                        <p class="mb-0">join</p>
                    </div>
                    <div style="margin:-45px -20px -30px !important; height:230px;" class="">
                        <img id='dao_cover_image' style="object-fit: cover; object-fit:center;"
                            class="h-100 w-100 rounded object-cover"
                            src="<?php if($res['status']){echo $res['cover'];} ?>"
                            data="https://images.unsplash.com/photo-1513151233558-d860c5398176?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="">
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="card-imgflex mt-1">
                            <img id='dao_image' src="<?php if($res['status']){echo $res['image'];} ?>" data="{{ asset('images/demi.jpg') }}" alt="">
                            <div class="cardHeading mt-4 py-2">
                                <p id='dao_name' class="card-heading whitespace-nowrap"> <?php if($res['status']){echo $res['name'];} ?></p>
                                <p id='dao_members' class="card-subheading whitespace-nowrap">
                                     <?php if($res['status']){echo (( $res['members'] > 1) ? " members" : " member");} ?>
                                </p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3 py-3 w-100 mt-4">
                            <button type="button" id='dao_setting' class="btn btn-success" data-toggle="modal" data-target="#DaoSetting" style='display:none'>Dao Settings</button>
                          
                            <button class='btn btn-danger whitespace-nowrap' id='leaveDao'
                                style='border:2px solid red;display:none'>Leave Dao</button>
                        </div>
                    </div>
                    <div id='dao_about' class="card-paragraph line-climb-3">
                        <?php if($res['status']){echo $res['description'];} ?>
                    </div>

                    <div class="">
                        <div class="d-flex">
                            <div class="card-small-div">
                                <span class="card-bold-word whitespace-nowrap">Assets:</span>
                                <a id='asset_name' href="#" target='_blank'
                                    class="card-link whitespace-nowrap d-flex align-items-center gap-3"><span
                                        id='dao_token_name'><?php if($res['status']){echo $res['code'];} ?></span><img id='dao_token_img' src="<?php if($res['status']){echo $res['image'];} ?>" style='' alt="">
                                        </a>
                            </div>
                            <div class="card-small-div flex-column align-items-start">
                                <span class="card-bold-word whitespace-nowrap">Website:</span>
                                <a id='dao_website' target='_blank' href="#"
                                    class="card-link whitespace-nowrap d-inline-block text-truncate"></a>
                            </div>
                            <div class="card-small-div flex-column align-items-start">
                                <span class="card-bold-word whitespace-nowrap">Toml url:</span>
                                <a id='dao_token_url' target='_blank' href="#"
                                    class="card-link whitespace-nowrap text-truncate">
                                    <?php if($res['status']){echo $res['url'];} ?>
                                </a>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 py-3">
                            <div class="card-imgflex-social-link " style='display:none'>
                                <a id='dao_twitter' href="">
                                    <img src="{{ asset('images/twiter.png') }}" alt="">
                                </a>
                            </div>
                            <div class="card-imgflex-social-link" style='display:none'>
                                <a id='dao_instagram' href="">
                                    <img src="{{ asset('images/instagram.jpeg') }}" alt="">
                                </a>
                            </div>
                            <div class="card-imgflex-social-link" style='display:none'>
                                <a id='dao_discord' href="">
                                    <img src="{{ asset('images/discord.png') }}" alt="">
                                </a>
                            </div>
                            <div class="card-imgflex-social-link" style='display:none'>
                                <a id='dao_reddit' href="">
                                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAASFBMVEVHcEz/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/RQD/NAD/PwD/aDr/s5z/nH7/e1b/WyT/xLH/imj/4NX/8ev///9xkjBnAAAADHRSTlMAFFyk2vT9KO//iszHtZsMAAABSElEQVR4AWxSB7aDMAxjg6md7XD/m35s/PqTtmJkSImUMfxjnOZl3bZ1madx+MY+H/DGMe8f9Hiu0GE9x274C77w2hu+mb3x2X/zSDeQGsXYzk/Oh5hiLiQuT44TGlDgzFyvmkRxqsHaCXJASnxdTgSrmMzQgR2JTyQQzHeCLiE51oLIVjIOU0sTloxGPpjUQTkgcMEz+5KIpG0ei9IQHRa+DBwxOVDJMqzqXO/eqwHf77OOYZPN89pb68Na4fGmtkZQY9LSp1IbgW6Tk56MlIQAwix6s9CQWMQ3YRBBQZA8ATXks0yK6mE5WctCukzbqFSvHuYAk201BekLOpSDqD3ZVttWkpeYyZXiUpYqmMP7uFHHVWYtJKEed3NhKAUhReTFX3B2V44IXCwlOiDjX+PnpSUFGP6GK1kj5AllHEJZj8jMSzD7AwBb/yl65xYVzAAAAABJRU5ErkJggg=="
                                        alt="">
                                </a>
                            </div>
                            <div class="card-imgflex-social-link" style='display:none'>
                                <a id='dao_telegram' href="">
                                    <img src="data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAHcAdwMBEQACEQEDEQH/xAAbAAEAAwEBAQEAAAAAAAAAAAAABQYHBAMBAv/EADwQAAEDAwAGBggEBQUAAAAAAAEAAgMEBREGEiExQVETFCJxgaEyQlJhkbHB0QdicuEjMzSi8CRDU2OC/8QAGgEBAAMBAQEAAAAAAAAAAAAAAAMEBQIGAf/EAC0RAAEDAgQEBgIDAQAAAAAAAAABAgMEEQUSITEyQVFhE3GRobHRgfAi4fFT/9oADAMBAAIRAxEAPwDcUAQBAfiWVkMbpJXNYxoyXOOAF9RFVbIfFVGpdSt3LTGkh1o6KN1Q8eseyz7lXY6B7uPQzJsUjbpGl/grtXpPdagnFQIW+zE0Dz3q6yjhbyuZsmIVD+dvIjJKuqlz0tTPJn25Cfqp0jYmyFVZZHbuX1PLWOc5Oea6scHvFXVkP8mrnZ+mQhcrGx26ISNmkbs5fUlKTSq6U5HSSNqG8pG7fiFXfRRO20LceJTs3W/mWO2aW0FUQypzSyH2zlp8eHiqMtFIzVuqGnBicUmj/wCK+3qWFrg4AtIIIyCFTNHc/SAIAgCAICMvd5prTBrTHWkd6ETTtd9h71NDA+VbNK1TVMp23dvyQz663isusutUyERj0YmnDW+HE+9bMUDIks31POz1Uk63eunTkcCmK4QBAEAQBAMoCUst+q7S8NY4yU2e1C47P/PJV5qZkvn1LdNWSQLZNU6fXQ0K13OmulMJqV+Ruc072nkVjSxOidlceignZM3MxTtUZMEAQEXfrvFaaMyu7UrjiOPONY/ZTQQrK63IrVVS2nZmXfkhmdXVTVlS+oqXl8rztJ+Q5BbrI2sblaeXkkdI5XvW6qeWV1Y5GUsBlLAZSwGUsBlLAZSwGUsBlLA67Xcai2Vbaimdt3OadzxyKjlibK3K4lgnfA/Oz/TTrXcILlRsqac9l28He08QVhSxOidlcepgmbMxHtOxRkp+JpGQxOkkcGsY0ucTwAX1EVVsh8VUal1MrvlzkutwkqHZEY7MTfZb9+JW/BCkTMvqeVqp1nkV67cvIj1MVwgCAIAgCAIAgCAIAgJrRW7m13FrZHYpZiGyjg08HeHyVWrg8Vl03Qu0NSsEmvCu/wBmmDcsM9MVbT249BQR0UbsPqDl/wCgfc481foIsz1evIy8UmyxpGnP4KDla5gDKAZQDKAZQDKAZQH7hilnkEcEb5Hnc1jST5L4rkal1U+ta5y2al1J+36H3Oqw6o1KWP8AOdZ/wH1IVOSuibw6l+HDJn8X8U9/T+yyUWh9rpm/x2PqX85HYHgAqUldK7bQ04sNgZxa+Zn9a1kddUxxfy2TPaz9IcQPJbDFVWIq9Dz0iIj3Im11+TxyujkIDS9D7ia+zxh7sywHon8zjcfgsOsi8OVbbLqelw+fxYUvumhTdMarrN/qBnLYQIm+G/zJWlRMywp31MfEJM9QvbQhMq0UhlAMoBlAM7QOJ3DmgJi36M3Wvw5tMYYz68/Z8t/kq0lXEznfyLcVBPLs2yd9P7LPb9CaOHDq6WSpd7I7DfLb5qjJXyLo1LGnFhcbdXrf2QsEcVHbodWGKOBg4MbjP3VNXPkW6rc0WsZElmpY9ad75AXluq0+iDv8VyqWO0W4rZhTUk07t0bHPPgF9a3M5G9T492RquXkY4XFx1nHtHae9ekPHXVdVPmUAygLR+H9X0d1lpiezPHkD8zf2JVDEGXjR3Q08KktKrOqFcrpemrqmXf0kz3fFxKuxtsxE7GfKuaRy91PFdnAQHTQW+suMmpRU0kxG8tHZb3k7Ao5JWR8a2JIoZJVsxLlptugzzqvuVTq844dv9x+yoSYh/zT1NWHCl3ld+E+y026zW+3AdUpWMfu1ztcfE7VQknkk4lNOGmih4GnfsaCoic4Km5NblsI1j7XAKRGdThX9D5SUr5XCeqyTvaCiutoh8RvNSRUZIQWmtT1fR+cA9qUiMeJ2+QKtUTc0ydtSjiL8lOvfQzFbp5oIAgO6xVPVLtTz5xql23vaQoZ2Z41aT0r8kzXfuynAcgnO/O1TEAygPh2oC62TTKkpqWGlq6V0IjaG68Xabs443jzWXNQvVyuatzZp8Tja1GPba3TYtVvu1Bcf6OqilPFgd2h4HaqD4ZI+JLGpFURS8DrnvU1UcA7Zy7g0b1wjVUlVyIRNRVS1Ow7GncwKZrUQiVyqdtDQ6mJJh2uDeSjc6+iHbW81JBcHYQFI/Eaq/oqQH2pXDyH1WnhzOJ34MbFn8LPyUrK1DFGUAygDNYvAbvRdj6l76Htc4zBcquEj0J3t/uK4iXMxq9kO5m5ZHJ3U5l2RhAEA4g8to9yAvdiqzWWyJ73F0jOw8k7SR+2Fj1EeSRUPRUcviQoq77FgtLad5Lg8OmadrT6qqPVS6yxKKMkCAIDLNNKrrOkVSActhDYh4DJ8yVu0TMsKd9TzOIPz1C9tCDVopBAEBJ6N03XL1TQY2OLs+DCoal+SJVLFIzPO1v7sp2ac0hpb/JIB2KhokHfuPy81FQvzQonQnxKPJUKvXUryuFAIAgCAsGh9VqVctK47JW6zc+0P2+SpVrLtR3Q0sNks9Y15k46RzJ3SRuLXBxIIO0LPtfQ1b2U7LfplRuqeqVjtU7hUeoTyPLv3L66ikyZ0T8EbcRh8TIq/nkWhrg4Ag5B2gjiqZoItz8yyNijc95w1oJJ9wX1EutkPirZLqYtUzmpqZqh2czSOkOfecr0rW5Wo3oeOc7O5XddTyXR8CAIC3/hzRmS4VFYR2YY9Rp/M79h5rOxF9mIzqauEx3kc/pp6k1p7bDWWnrMbcy0pL9nFnrffwVWhlySZV2Uu4nB4kOZN2/HMzVbZ50IAgCA9qSodS1UVQzfG4Oxz5hcvaj2q1TuN6xvRyciQul5NS0xUwcyN3pk7z7u5VoaZGLmdqpcqa3xEys0QiVbKBO6PaT1VmIifmej/wCInaz9J+m7uVSopGzapopdpa58Gi6t6fRaNItJ7bNYZ2UVU189QzUawek3O8kcNmVRp6SRJkzJohpVddC6BUY7VdDOlsmAEAQBAazonbDa7LDFIMTSfxJfc48PAYHgvP1Uviyqqbcj1FFAsMKIu+6ku9oe0tcAQRgg8VXLapfQybSmzOs1xc1gPVZcuhdyHs94+WFv0s/jM7pueXrKZYJLJsu31+CHyrJUGUAygGUAQDKAZQDKAZQDKAZQFm0HshuNeKydn+lpnZGR6bxtA8N/wVGun8NmRN1+DRw+l8V+d3Cnuppg2BYp6I+oDgvNrp7vQvpaluw7WvG9juBCkildE/M0hngbOxWOMmu1sqrRWOpatmCPQePRkHML0EUrZW5mnl54HwPyP/04sqQiGUAygGUAygGUAygGUAygJXR6yVN8rOjiyyBhHTTY2NHIcyoKiobC2678kLNLSvqH2Tbmv7zNYoaOChpY6amjDI4xhoH+b1gPe57lc7c9PHG2NqNamiHQuTsIAgOG7WulutKaesi1272kbHNPMHgpIpXROzNIZoGTNyvQzS/6LV1nc6RrXVFIN0zBtaPzDh37ltQVccumy9Dz9TQyQa7t6/ZA5VspDKAZQDKAZQDKAL4Cz6PaHVlxc2aua6lpd+CMSP7hwHvKpT1zI9Gar7GhS4fJL/J+jfdTSKGjp6CmZT0sTYo2DY0f5tKxnvc92Z256CONsbUa1LIdC5OwgCAIAgPmAgK/d9ELVcXOkbEaaY75IMDPeNxVuKtlj0vdO5Rnw+GXW1l7FVrtAblESaOaCobwBOo76jzV5mIxrxJYzZMKlbwKi+xBVlkudFnrNIWY/wCxh+RVptRE/ZSm+lmZxN+Ps4A1xdqgbeSluQ2W9iTo9HrtW46tRlwPEyMH1UL6mJm6/JYZRzv4W+6fZO0H4f1shBr6qKFvFsXbd9APNVH4kxOBLlyPCZF43W8tS2WfRi12oh8MHSTD/emOs7w4DwVCWrll0VdOhpwUUMOqJr1UmsKuWz6gCAID/9k="
                                        alt="">
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--<div class="modal fade" id="manageAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"-->
    <!--    aria-hidden="true">-->
    <!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
    <!--        <div class="modal-content cardEndDiv p-0 fa-ctn fa-modal-content">-->
    <!--            <div class="d-flex align-items-center justify-content-end w-100">-->
    <!--                <button type="button" class="close p-3 pb-0 m-0 border-0 bg-transparent" data-dismiss="modal"-->
    <!--                    aria-label="Close">-->
    <!--                    <span aria-hidden="true">&times;</span>-->
    <!--                </button>-->
    <!--            </div>-->
    <!--            <div class="modal-body px-4 py-0 w-100">-->
    <!--                <div class="form-group">-->
    <!--                    <label for="">-->
    <!--                        <span class="asset-details-label mb-0">Add new admin:</span>-->
    <!--                    </label>-->
    <!--                    <div class="d-flex flex-column flex-md-row align-items-end gap-2">-->
    <!--                        <input oninput='searchAdminUser()' id="dao_search_admin" type="text"-->
    <!--                            class="form-control h-auto mt-1">-->
    <!--                        <button onclick='searchAdminUser()'-->
    <!--                            class="btn btn-secondary px-2 py-1.5"><small>Search</small></button>-->
    <!--                    </div>-->
    <!--                </div>-->
    <!--                <div id='addNewAdmin' class="m-0 mt-0 mt-md-5 p-0" style='display:none'>-->
    <!--                    <p class="mb-0 text-success manage-admin-heading">Address founded</p>-->
    <!--                    <div-->
    <!--                        class="d-flex flex-column align-items-center justify-content-between gap-1 mb-2 new-admin-ctn">-->
    <!--                        <div id='dao_search_admin_result' style='width:100%;max-height:300px;overflow:auto'>-->

    <!--                        </div>-->
                            <!--<div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">-->
                            <!--    <img class="" src="{{asset('/images/discord.png')}}" alt="">-->
                            <!--    <p id='dao_search_admin_found' class="mb-0  column-content text-truncate text-break text-wrap"></p>-->
                            <!--</div>-->
    <!--                        <div class="mb-3" id='dao_admin_rules'>-->
    <!--                            <span class="text new-admin-note">-->
    <!--                                <strong class="text-danger">Note:</strong>-->
    <!--                                Before you confirm, make sure to read the admin authorities.-->
    <!--                            </span>-->
    <!--                            <div-->
    <!--                                class="text-left w-100 d-flex flex-column flex-md-row align-items-start align-md-items-center justify-content-between mt-3 px-1.5 px-md-0">-->
    <!--                                <div class="d-flex align-items-center justify-content-start px-0 px-md-3">-->
    <!--                                    <input id="manageAdminCheck" type="checkbox">-->
    <!--                                    <label class="new-admin-note" for="">I have read the admin authorities</label>-->
    <!--                                </div>-->
    <!--                                <button id="manageAdminConfirm"-->
    <!--                                    class="btn btn-success text-white text mt-2 mt-md-0"><small>Confirm</small></button>-->
    <!--                            </div>-->
    <!--                        </div>-->

    <!--                        <div class="d-flex align-items-end justify-content-end gap-2 mb-0 w-100">-->
    <!--                        </div>-->
    <!--                    </div>-->

    <!--                </div>-->
    <!--                <div class="m-0 py-2 p-0">-->
    <!--                    <p class="mb-0 text-danger manage-admin-heading">All Admins</p>-->
    <!--                    <div id='dao_admin_lists' style='width:100%;max-height:300px;overflow:auto'>-->

    <!--                    </div>-->
                        <!--<div-->
                        <!--    class="d-flex flex-column align-items-center justify-content-between gap-1 mb-2 new-admin-ctn">-->
                        <!--    <div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">-->
                        <!--        <img class="" src="{{asset('/images/discord.png')}}" alt="">-->
                        <!--        <p class="mb-0  column-content text-truncate inline-block text-break text-wrap">FGDKXQTCPOJVVBBYSNADBDSJBASD2MRK2DXKZANU3I</p>-->
                        <!--    </div>-->
                        <!--    <div class="d-flex align-items-start align-md-items-end justify-content-start justify-content-md-end gap-2 mt-2 w-100">-->
                        <!--        <button class="btn btn-danger text-white text "><small>Remove</small></button>-->
                        <!--    </div>-->
                        <!--</div>-->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="d-flex align-items-center justify-content-end gap-3 modal-footer m-0 p-0 py-3 px-3 w-100">-->
    <!--                <button type="button" class="btn btn-warning text " style='display:none !important'>Save</button>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
    
    <div class="modal fade" id="DaoSetting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-content proposal_modal-content">

          <div class="proposal_modal-body">
            <div class="">
              <div class="d-flex justify-content-between overflow-hidden gap-3">
                <div style="position:relative; width:100px; height:100px;" class=" ">
                  <div class="modal_edit_btn" onclick='enableEdit("image")' style='cursor:pointer'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" width="24px">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </div>
                  <img style="width:100px; height: 100px; border-radius:50%;"
                    src="https://plus.unsplash.com/premium_photo-1695186450461-777ea482f34b?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8"
                    id='dao_save_img' alt="Dao">
                  <input id='dao_save_image_edit' type='file' style='visibility:hidden' />
                </div>
                <div class="flex-grow-1 ml-4">
                  <div class="d-flex align-items-center gap-2 EditModal-title">
                    <span class="asset-stellar-p">Project Name:</span>
                    <span class="asset-details-text" id='dao_save_name'>Audi khan</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 EditModal-title">
                    <span class="asset-stellar-p">Asset Code:</span>
                    <span class="asset-details-text" id='dao_save_code'>XLM</span>
                  </div>
                  <div class="d-flex align-items-center gap-2 EditModal-title">
                    <span class="asset-stellar-p">Home
                      Domian:</span>
                    <a style="text-decoration:none; color:blue;" id='dao_save_domain_href' href="">
                      <span style="color: #578aff;" class="asset-details-text"
                        id='dao_save_domain'>https://web.whatsapp.com/moadsdsdsncie</span>
                    </a>
                  </div>
                  <div class="d-flex align-items-center gap-2 EditModal-title">
                    <span class="asset-stellar-p">TOML:</span>
                    <a style="text-decoration:none; color:blue;" id='dao_save_domain_href' href="">
                      <span style="color: #578aff;" class="asset-details-text"
                        id='dao_save_domain'>https://web.whatsapp.com/moadsdsdsncie</span>
                    </a>
                  </div>
                </div>
              </div>
              <div class="py-3">
                <div class="d-flex align-items-center asset-stellar-p">Description:
                  <div style="margin-left:12px;cursor:pointer" class="modal_edit" id='manageAdminBut' onclick='enableEdit("about")'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" width="24px">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </div>
                </div>
                <div style="font-family:'MontReg';" id='dao_save_about' class="asset-details-text mt-2">Lorem ipsum
                  dolor, sit amet consectetur adipisicing elit. Quas vitae vero veniam doloremque odit saepe, ea error
                  omnis! Sit nisi officiis repellendus iure blanditiis earum distinctio deleniti veritatis adipisci
                  aperiam?</div>
                <input class='form-control' placeholder='Description....' id='dao_save_about_edit'
                  style='display:none' />

              </div>
              <div class="py-3">
                <div class="d-flex align-items-center asset-stellar-p">Socail Profile:
                  <div style="margin-left:12px;cursor:pointer" class="modal_edit" style='display:none'>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" width="24px">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                  </div>
                </div>
                <div class="py-3 d-flex align-items-center justify-content-between flex-wrap">
                  <button id='dao_save_twitter' class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-between mb-3" onclick='saveSocials("twitter")'>
                    <img class="w-img border" src="{{asset('/images/x.webp')}}" alt="">
                    <div id='dao_save_twitter_div' class="font-medium text-muted ml-2">Connect</div>
                  </button>
                  <button id='dao_save_telegram' class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-between mb-3">
                    <img class="w-img border" src="{{asset('/images/download.jpeg')}}" alt="">
                    <div id='dao_save_telegram_div'  class="font-medium text-muted ml-2">Connect</div>
                  </button>
                  <button id='dao_save_reddit' class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-between mb-3" onclick='saveSocials("reddit")'>
                    <img class="w-img border" src="{{asset('/images/Reddit.png')}}" alt="">
                    <div id='dao_save_reddit_div'  class="font-medium text-muted ml-2">Connect</div>
                  </button>
                </div>
                <div class="d-flex justify-content-end w-25 ml-auto">
                  <button id='dao_save_button' class="btn assetSearch w-100 pt-0 mt-0" style='display:none'>Save</button>
                </div>
                <div class="py-3">
                  <div class="d-flex align-items-center asset-stellar-p">Admins:
                    <div style="margin-left:12px;cursor:pointer" class="modal_edit" style='display:none'>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" width="24px">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                    </div>
                  </div>
                  <div id='dao_admin_lists' class="mt-2 d-flex flex-wrap w-100 gap-3">
                    <!--<div-->
                    <!--  class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-start position-relative flex-grow-1 gap-3">-->
                    <!--  <img class="w-img"-->
                    <!--    src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="">-->
                    <!--  <div class="font-normal text-secondary ml-2 font-xs">GAAHFDB.....DJFDSKBV</div>-->
                    <!--  <div class="position-absolute cross-dao-setting">-->
                    <!--    <svg class="text-danger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"-->
                    <!--      fill="currentColor" width="20px" heigth="20px">-->
                    <!--      <path fill-rule="evenodd"-->
                    <!--        d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"-->
                    <!--        clip-rule="evenodd" />-->
                    <!--    </svg>-->
                    <!--  </div>-->
                    <!--</div>-->
                  </div>

                </div>
                <div class="py-3">
                  <div class="d-flex align-items-center asset-stellar-p">Add Admins:
                    <div style="margin-left:12px;cursor:pointer" class="modal_edit" onclick='enableEdit("admins")'>
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" width="24px">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                      </svg>
                    </div>
                  </div>
                  <div id='addAdminInputField' class="mt-2 flex-wrap w-100 gap-3" style='display:none !important'>
                    <div
                      class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-start position-relative flex-grow-1 gap-3">
                      <input oninput="searchAdminUser(event)" id="dao_search_admin" type="text" class="border-0 outline-none p-1 font-xs w-100" placeholder="Enter Wallet address">
                    </div>
                    <button onclick='searchAdminUser(event)' class="btn btn-info rounded-md">Search</button>
                  </div>
                  <div id='addNewAdmin' class=" py-3" style='display:none'>
                    
                    <div class="asset-stellar-p">Address found:</div>
                    <div id='dao_search_admin_result' style='width:100%;max-height:300px;overflow:auto'>

                    </div>
                    <div class="d-flex gap-3 align-items-center justify-content-between">
                      <div class="gap-3 align-items-center" id='dao_admin_rules'>
                        <input width="30px" height="30px" id='manageAdminCheck' type="checkbox">
                        <p class="p-0 m-0 font-xs">I've read and agree to the <a class="text-info" href="">terms and
                            condition</a></p>
                      </div>
                      <div class="">
                        <button id='manageAdminConfirm' class="btn btn-danger rounded-md">Approve</button>
                      </div>
                    </div>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="approveWallet">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="d-flex align-items-center gap-2">
                    <h2 class="heading">DAO Admins</h2>
                    <button style="margin-bottom: 0.5rem;" type="button"
                        class="border-0 bg-transparent d-flex align-items-center py-1 justify-content-center  text-secondary"
                        data-toggle="tooltip" data-placement="right"
                        title="Approved wallets are managed by the project team and listed in the project's toml file. They ensure transparency in governance and decision-making.">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" width="22px" height="22px">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>
        <div class="addressLink">
            <div class="row" id='dao_others_address'>
                <div class="col-lg-4 col-md-12 col-sm-12">
                    <strong class="text-success">DAO Creator</strong>
                    <div class="column-content">
                        <p id='dao_token_creator'></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="propFilter">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="propFilterInner">
                    <a id='createProposal' href="{{ route('dao.proposal.create', 'PROPOSAL_CREATE') }}"
                        style="width:200px; whitespace:no-wrap;display:none;margin-left:auto;display:flex; " class="btn btnCreate">
                        Create Proposal <img class="plu" src="{{ asset('images/11.svg') }}" alt="">
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="endedCard">
    <div class="container">
        <div class="d-flex proposal_card_container">
            <div class="proposal_right_card_container">
                <div class="">
                    <ul class="nav nav-tabs pro-nav-tabs" id="myTabs">
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link active" id="tab1" data-toggle="tab"
                                href="#content1">Proposals <span id='tab1_count'></span></a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab3" data-toggle="tab" href="#content3">Members
                                </a>
                        </li>
                        <li class="nav-item">
                            <a class="pro-nav-link nav-link" id="tab4" data-toggle="tab" href="#content4">Delegates</a>
                        </li>
                        <li id='prop_review_tab' class="nav-item" style='display:none'>
                            <a class="pro-nav-link nav-link" id="tab5" data-toggle="tab" href="#content5">Proposals in
                                Review</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="content1">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="col-12" id="proposal_views">
                                        <div style='font-size:20px; margin:60px;'>
                                            <center>Loading Proposals...</center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="tab-pane fade show" id="content2">
                            <div class="row mt-0">
                                <div class="cardEndDiv"> -->
                                    <!-- <div id='bulletins_views'>
                                        <center>Loading Bulletins</center>
                                    </div> -->
                                    <!--<div class="my-4">-->
                                    <!--    <div class="d-flex flex-wrap justify-content-between">-->
                                    <!--        <div class="cardEndDetail">-->
                                    <!--            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"-->
                                    <!--                alt="Profile Image" class="image">-->
                                    <!--            <div class="text text-center">FGDKXQTCP.....DXKZANU3I-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--        <div class="text text-muted">12/02/2023</div>-->
                                    <!--    </div>-->
                                    <!--    <div class="bultin_description text">-->
                                    <!--        <p>We will introduce an incentivized referral program, rewarding existing-->
                                    <!--            LumosDAO members for bringing in new users. This program will encourage-->
                                    <!--            community growth while rewarding loyal members who contribute to-->
                                    <!--            expanding-->
                                    <!--            our user base.</p>-->
                                    <!--    </div>-->
                                    <!--    <div class="d-flex align-items-center justify-content-start gap-3 bullet-icon">-->
                                    <!--        <button id="like"-->
                                    <!--            class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">-->
                                    <!--            <i id="like-icn" class="fa fa-thumbs-o-up"></i>-->
                                    <!--            <span class="text text-muted">Like</span>-->
                                    <!--        </button>-->
                                    <!--        <button id="dislike"-->
                                    <!--            class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">-->
                                    <!--            <i id="dislike-icn" class="fa fa-thumbs-o-down"></i><span-->
                                    <!--                class="text text-muted">Dislike</span>-->
                                    <!--        </button>-->
                                    <!--        <button id="comment"-->
                                    <!--            class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start gap-3">-->
                                    <!--            <i id="" class="fa fa-comment-o "></i><span-->
                                    <!--                class="text text-muted">Comment</span>-->
                                    <!--        </button>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!--<div class="bullet-icon">-->
                                    <!--    <div id="commentSec" class="cardEndDetail">-->
                                    <!--        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"-->
                                    <!--            alt="Profile Image" class="image w-img">-->
                                    <!--        <div id="comment-pl" class="column-content">-->
                                    <!--            <div class="text">-->
                                    <!--                <p class="text font-weight-bold">Admin</p>-->
                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!-- commnets -->
                                    <!--<div id="comment-box" style="width: 90%; margin-right:auto;margin-left:40px;"-->
                                    <!--    class="d-flex align-items-end gap-4 mt-5">-->
                                    <!--    <div class="form-group w-100">-->
                                    <!--        <label for="">-->
                                    <!--            <span class="asset-details-label whitespace-nowrap">Write a-->
                                    <!--                comment:</span>-->
                                    <!--        </label>-->

                                    <!--        <div class="form-control d-flex align-items-center justify-content-between">-->
                                    <!--            <input id="comment-input" type="text" placeholder="Great...."-->
                                    <!--                class="border-0 bg-transparent text w-100 h-100">-->
                                    <!--            <button id="comment-send" type="button" class="btn border-0 mb-1">-->
                                    <!--                <svg class="text-secondary" xmlns="http://www.w3.org/2000/svg"-->
                                    <!--                    width="24" height="24" viewBox="0 0 24 24">-->
                                    <!--                    <path fill="currentColor" d="m2 21l21-9L2 3v7l15 2l-15 2z" />-->
                                    <!--                </svg>-->
                                    <!--            </button>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                    <!--<div class="">-->
                                    <!--    <div class="row">-->
                                    <!--        <div class="poll-card cardEndDiv">-->
                                    <!--            <div class="">-->
                                    <!--                <div class="d-flex justify-content-between">-->
                                    <!--                    <div class="cardEndDetail d-flex justify-content-between gap-3">-->
                                    <!--                        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"-->
                                    <!--                            alt="Profile Image" class="image w-img">-->
                                    <!--                        <div class="text text-center">-->
                                    <!--                            FGDKXQTCP.....DXKZANU3I-->
                                    <!--                        </div>-->
                                    <!--                    </div>-->
                                    <!--                    <div class="text text-muted">12/02/2023|05:23 pm</div>-->
                                    <!--                </div>-->
                                    <!--                <div class="text m-4">-->
                                    <!--                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.-->
                                    <!--                        Reiciendis-->
                                    <!--                        quis dolore, quidem saepe facere assumenda aperiam,-->
                                    <!--                        quibusdam-->
                                    <!--                        pariatur fugiat illum sunt natus, eum consectetur.-->
                                    <!--                        Exercitationem-->
                                    <!--                        excepturi, quos consectetur error itaque explicabo harum-->
                                    <!--                        corrupti,-->
                                    <!--                        quibusdam ipsam voluptatibus similique modi dignissimos?-->
                                    <!--                        Excepturi-->
                                    <!--                        sequi, ad dolores minus tempore sunt quod iste autem nulla.-->
                                    <!--                    </p>-->
                                    <!--                </div>-->
                                    <!--            </div>-->

                                    <!--            <div class="options">-->

                                    <!--                <div class="option option-1">-->
                                    <!--                    <div class="analytic">-->
                                    <!--                        <div class="bar"></div>-->
                                    <!--                        <div class="percent">50%</div>-->
                                    <!--                    </div>-->
                                    <!--                    <div class="input">-->
                                    <!--                        <input class="poll-input" type="radio" id="option-1"-->
                                    <!--                            name="option" hidden>-->
                                    <!--                        <label class="option-lable text-left" for="option-1">1. Java&nbsp;<i-->
                                    <!--                                class="fa fa-check tick" aria-hidden="true"></i>-->
                                    <!--                        </label>-->
                                    <!--                    </div>-->

                                    <!--                </div>-->

                                    <!--                <div class="option option-2">-->
                                    <!--                    <div class="analytic">-->
                                    <!--                        <div class="bar"></div>-->
                                    <!--                        <div class="percent">50%</div>-->
                                    <!--                    </div>-->
                                    <!--                    <div class="input">-->
                                    <!--                        <input class="poll-input" type="radio" id="option-2"-->
                                    <!--                            name="option" hidden>-->
                                    <!--                        <label class="option-lable text-left" for="option-2">2. Python&nbsp;<i-->
                                    <!--                                class="fa fa-check tick"-->
                                    <!--                                aria-hidden="true"></i></label>-->
                                    <!--                    </div>-->
                                    <!--                </div>-->

                                    <!--                <div class="option option-3">-->
                                    <!--                    <div class="analytic">-->
                                    <!--                        <div class="bar"></div>-->
                                    <!--                        <div class="percent">50%</div>-->
                                    <!--                    </div>-->
                                    <!--                    <div class="input">-->
                                    <!--                        <input class="poll-input" type="radio" id="option-3"-->
                                    <!--                            name="option" hidden>-->
                                    <!--                        <label class="option-lable text-left" for="option-3">3.-->
                                    <!--                            JavaScript&nbsp;<i class="fa fa-check tick"-->
                                    <!--                                aria-hidden="true"></i></label>-->
                                    <!--                    </div>-->
                                    <!--                </div>-->

                                    <!--                <div class="option option-4">-->
                                    <!--                    <div class="analytic">-->
                                    <!--                        <div class="bar"></div>-->
                                    <!--                        <div class="percent">50%</div>-->
                                    <!--                    </div>-->
                                    <!--                    <div class="input">-->
                                    <!--                        <input class="poll-input" type="radio" id="option-4"-->
                                    <!--                            name="option" hidden>-->
                                    <!--                        <label class="option-lable text-left" for="option-4">4. Don't-->
                                    <!--                            Judge&nbsp;<i class="fa fa-check tick"-->
                                    <!--                                aria-hidden="true"></i></label>-->
                                    <!--                    </div>-->
                                    <!--                </div>-->

                                    <!--            </div>-->
                                    <!--        </div>-->
                                    <!--    </div>-->
                                    <!--</div>-->
                                <!-- </div>
                            </div> -->

                        <!-- </div> -->

                        <div class="tab-pane fade" id="content3">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="d-flex flex-column gap-4" id='dao_users'>
                                    </div>
                                    <div style='display:flex; align-items:center'>
                                        <button id='next_dao_user_info' class="btn" style='display:none'>Next</button>
                                        <button id='pre_dao_user_info' class="btn"
                                            style='margin-left:15px;display:none'>Previous</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content4">
                            <div class="row mt-0">
                                <div class="cardEndDiv">
                                    <div class="d-flex align-items-end gap-4">
                                        <div class="form-group w-100">
                                            <label for="">
                                                <span class="asset-details-label whitespace-nowrap">Add
                                                    Delegate:</span>
                                            </label>
                                            <input oninput="searchDelegate()" id='dao_delegate_search' type="text"
                                                placeholder='Wallet address here' class="form-control">
                                        </div>
                                        <div class="">
                                            <button type="button" onclick='searchDelegate()'
                                                class="btn btnCreate border-0 mb-1">
                                                <p class="mb-0 text-white">Search</p>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="my-4" style='display:none' id='user_delegates_search'>
                                        <div class="mb-2">
                                            <span class="text-sm text-success text">Member found</span>
                                        </div>
                                        <div style='overflow:auto;max-height:300px' id='searchDelegateResults'>
                                        </div>
                                    </div>
                                    <div class="my-4" style='display:none' id='user_delegates'
                                        style='border-top:1px solid rgba(0,0,0,.5)'>
                                        <div class="mb-2">
                                            <span class="text-sm text-success text">Delegates</span>
                                        </div>
                                        <div style='overflow:auto;max-height:300px' id='user_delegates_view'>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="content5">
                            <div class="row mt-0">
                                <div class="cardEndDiv" id='proposal_review'>
                                    <div style='font-size:20px; margin:60px;'>
                                        <center>Loading Proposals...</center>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex flex-column tweet-ctn">
                <div style="margin-top: 40px; max-height:600px; overflow-y:scroll"
                    class="proposal_status-card w-100 py-3 example">
                    <div class="proposal_status-SideCard sticky top-0">
                        <div class="d-flex align-items-start justify-content-start gap-2">
                            <h2 class="heading">Bulletin</h2>
                            <button style="margin-bottom: 0.5rem;" type="button"
                                class="border-0 bg-transparent d-flex align-items-center  justify-content-center  text-secondary"
                                data-toggle="tooltip" data-placement="right"
                                title="Discover the active members of this DAO who consistently participate in voting on proposals. Their engagement drives the decision-making process.">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="22px" hetight="22px">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>
                        <div class="d-flex align-items-center justify-content-end gap-3">
                            <button id='add_poll_info' class="btn font-xs whitespace-nowrap p-0 text-info"  style='display:none' type="button"
                                data-toggle="modal" data-target="#addPollingModal">Add Polls</button> <span class="text-secondary font-xxs">|</span> 
                            <button id='add_bulletin_info' style='display:none'
                                class="btn font-xs whitespace-nowrap p-0 text-info" type="button" data-toggle="modal"
                                data-target="#addBulletinModal">Add Bulletin</button>
                        </div>
                    </div>
                    <div class="text-center w-100" id='bulletins_views'>
                                        <center>Loading Bulletins</center>
                    </div>
                  </div>


                <div id='topVoters' style="margin: top 15px; disp lay:none" class="proposal_status-card w-100">
                    <div class="proposal_status-SideCard">
                        <div class="d-flex align-items-start justify-content-start gap-2">
                            <h2 class="heading">Top Voters</h2>
                            <button style="margin-bottom: 0.5rem;" type="button"
                                class="border-0 bg-transparent d-flex align-items-center  justify-content-center  text-secondary"
                                data-toggle="tooltip" data-placement="right"
                                title="Discover the active members of this DAO who consistently participate in voting on proposals. Their engagement drives the decision-making process.">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="22px" height="22px">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                            </button>
                        </div>

                        <div class="paragraph">
                            <p>Participated <br> in Proposal</p>
                        </div>
                    </div>
                    <div id='topVotersView' class="">
                        <!--<div class="d-flex justify-content-between align-items-baseline py-2">-->
                        <!--        <div class="proposal_sideCard_banner">-->
                        <!--            <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">-->
                        <!--            <span class="">ByGBV6...SYEN</span>-->
                        <!--        </div>-->
                        <!--        <div class="proposal_status-SideCard">-->
                        <!--            <h2 class="heading">12</h2>-->
                        <!--        </div>-->
                        <!--</div>-->
                    </div>
                </div>
            </div>
           <div class="modal-dialog modal-dialog-centered">
                <div class="modal fade" id="addPollingModal" tabindex="-1" aria-labelledby="addPollingModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header px-4 pt-2 p-0">
                                <h4 class="heading" id="addPollingModal">Add Polls</h4>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="p-4">
                                <div id="poll">
                                    <form id="pollForm" data='2'>
                                        <label for="">
                                            <p class="m-0 p-0">Write a question?</p>
                                        </label>
                                        <textarea class="form-control h-auto mb-2" name="" id="poll_question" cols="30"
                                            rows="2" placeholder="Write Question here:" required></textarea>
                                        <div
                                            class=" poll-option d-flex align-items-center justify-content-between gap-2">
                                            <input class="pollingInput form-control h-auto w-50" type="text"
                                                id="poll_option_value_1" name="option_1" placeholder="Option 1"
                                                required>
                                        </div>
                                        <div
                                            class="poll-option d-flex align-items-center justify-content-between gap-2">
                                            <input class="pollingInput form-control h-auto w-50" type="text"
                                                id="poll_option_value_2" name="option_2" placeholder="Option 2"
                                                required>
                                        </div>
                                        <button class="btn btn-secondary mt-2" onclick='addNewPollOption()'
                                            type="button" id="addOption">Add Option</button>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id='poll_cancel' class="btn btn-outline-dark"
                                    data-dismiss="modal">Cancel</button>
                                <button type="button" onclick="addNewPoll(event)"
                                    class="btn btn-warning">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal fade" id="addBulletinModal" tabindex="-1" aria-labelledby="addBulletinModal"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header px-4 pt-2 p-0">
                                <h4 class="heading" id="addBulletinModal">Add Bulletin</h4>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="p-4">
                                <div class="d-flex flex-column align-items-end gap-2 px-1">
                                    <div class="form-group w-100">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <label for="">
                                                <span class="asset-details-label whitespace-nowrap">Add Bulletin:</span>
                                            </label>

                                        </div>
                                        <textarea id='bulletin_msg' type="text" class="form-control h-auto"
                                            rows="4"></textarea>
                                    </div>
                                    <div class="">
                                        <button onclick='addBulletin()' type="button"
                                            class="btn btnCreate border-0 mb-1 mt-0">
                                            <p class="mb-0 text-white">Submit</p>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal fade" id="BulletinView" tabindex="-1" aria-labelledby="BulletinView"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header px-4 pt-2 p-0">
                                <h4 class="heading">Bulletin</h4>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="">
                                <div class="d-flex flex-column align-items-end gap-2 px-1" id='bulletin_modal_view'>
                                     
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal fade" id="voterView" tabindex="-1" aria-labelledby="voterView"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header px-4 pt-2 p-0">
                                <h4 class="heading" id="voterView">Voters</h4>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div style="min-height: 40vh;" class="p-4">
                                <div class="d-flex flex-column align-items-center gap-2 px-1">
                                <div class="d-flex flex-column align-items-center gap-4" id="dao_users">
                                    <div class="cardEndDetail d-flex justify-content-between gap-3">
                                        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image w-img">
                                        <div class="text text-center">
                                            GA6B4IASSKD6EO3NH3JRXKNCAHT7GDS3VWL676OTI27ZAR4CM4USWMNZ
                                        </div> 
                                    </div>
                                
                                    <div class="cardEndDetail d-flex justify-content-between gap-3">
                                        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image w-img">
                                        <div class="text text-center">
                                            GA6B4IASSKD6EO3NH3JRXKNCAHT7GDS3VWL676OTI27ZAR4CM4USWMNZ
                                        </div> 
                                    </div>
                                
                                    <div class="cardEndDetail d-flex justify-content-between gap-3">
                                        <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image w-img">
                                        <div class="text text-center">
                                            GA6B4IASSKD6EO3NH3JRXKNCAHT7GDS3VWL676OTI27ZAR4CM4USWMNZ
                                        </div> 
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
</section>
<script>
// Get references to DOM elements
const btnLike = document.getElementById('like');
const likeIcon = document.getElementById('like-icn');
const btnDisLike = document.getElementById('dislike');
const disLikeIcon = document.getElementById('dislike-icn');
const comment = document.getElementById('comment');
const commentBox = document.getElementById('comment-box');
const commentPlate = document.getElementById('comment-pl');
const commentSec = document.getElementById('commentSec');
const commentInput = document.getElementById('comment-input');
const commentSend = document.getElementById('comment-send');
var memberList = document.getElementById('memberList');
const manageAdminCheck = document.getElementById('manageAdminCheck');
const manageAdminConfirm = document.getElementById('manageAdminConfirm');



manageAdminConfirm.classList.add('d-none');
manageAdminCheck.addEventListener('click', function() {
    if (manageAdminCheck.checked) {
        manageAdminConfirm.classList.remove('d-none');
    } else {
        manageAdminConfirm.classList.add('d-none');
    }
});


// commentBox.classList.add('d-none');
// commentSec.classList.add('d-none');
// btnLike.addEventListener('click', function() {
//     btnLike.classList.toggle('like-active');
//     likeIcon.classList.add('fa-thumbs-up');
//     btnDisLike.classList.remove('like-active');
//     disLikeIcon.classList.remove('fa-thumbs-down');
// });

// btnDisLike.addEventListener('click', function() {
//     btnDisLike.classList.toggle('like-active');
//     disLikeIcon.classList.add('fa-thumbs-down');
//     btnLike.classList.remove('like-active');
//     likeIcon.classList.remove('fa-thumbs-up');
// });

// comment.addEventListener('click', function() {
//     commentBox.classList.toggle('d-none');
// });

// commentSend.addEventListener('click', function() {
//     commentSec.classList.remove('d-none');
//     let newComment = document.createElement('small');
//     newComment.textContent = commentInput.value;
//     commentPlate.appendChild(newComment);
//     commentInput.value = '';
// });

// document.addEventListener('click', function(event) {
//     const memBan = document.getElementsByClassName('member-ban-modal');
//     for(let i =0;i<memBan.length;i++)  {
//         const elem = memBan[i]
//         elem.classList.add('d-none');
//     }
// });

function toggleMemberModal(id, m, event) {
    E(m).classList.toggle('d-none');
    event.stopPropagation();
    E(m).onclick = (event) => {
        event.stopPropagation();
    }
}
// memberList.addEventListener('mouseover', function() {
//     const memBan = document.querySelector('.member-ban-modal');
//     memBan.forEach((elem) => {
//         elem.classList.remove('d-none');
//     })
// });
// memberList.addEventListener('mouseout', function() {
//     const memBan = document.querySelector('.member-ban-modal');
//     memBan.forEach((elem) => {
//         elem.classList.add('d-none');
//     })
// });
// const options = document.querySelectorAll('.poll-input')
// const analytics = document.querySelectorAll('.analytic')

// votingData = {
//     'option-1': 1,
//     'option-2': 2,
//     'option-3': 1,
//     'option-4': 3
// }

// const getTotalVotes = () => {
//     let totalVotes = 0
//     for (i = 1; i <= 4; i++) {
//         totalVotes += votingData[`option-${i}`]
//     }
//     return totalVotes
// }

// const displayResult = () => {
//     var total = 0
//     var widths = []
//     options.forEach(option => {
//         var ID = option.id
//         option.parentNode.parentNode.querySelector('.percent').textContent = Math.floor(votingData[ID] /
//             getTotalVotes() * 100) + '%'
//         option.parentNode.parentNode.querySelector('.bar').style.width = Math.floor(votingData[ID] /
//             getTotalVotes() * 100) + '%'
//         total += Math.floor(votingData[ID] / getTotalVotes() * 100)
//         widths.push(Math.floor(votingData[ID] / getTotalVotes() * 100))
//     })
//     options.forEach(option => {
//         if (total < 100) {
//             var min = Math.min(widths[0], widths[1], widths[2], widths[3])
//             min += (100 - total)
//         }
//         option.parentNode.parentNode.querySelector('.analytic').style.display = 'block'
//     })

// }

// const disableOptions = () => {
//     options.forEach(option => {
//         option.disabled = true
//     })
// }

// options.forEach(option => {
//     option.addEventListener('click', e => {
//         e.preventDefault()
//         option.style.color = 'display:none;'
//         var option_id = e.target.id
//         votingData[option_id] += 1

//         var analytic = e.target.parentNode.parentNode.querySelector('.analytic')
//         var bar = analytic.querySelector('.bar')
//         bar.style.backgroundColor = 'skyblue'
//         var percent = analytic.querySelector('.percent')
//         e.target.parentNode.parentNode.querySelector('.tick').style.display = 'inline'
//         displayResult()
//         disableOptions()
//     })
// })
</script>
<script>
/* VARIABLES */
var dao;
var daoUsers;
var daoDelegatee = [];
var proposals = [];
var bulletins = [];
var tweets = [];
var is_Admin = false;
var dao_users_page = 1;
var dao_user_page_segment = 20;
var inbox_link = "{{route('proposal.inbox')}}"
var logoSaveImg = null

/* RETRIEVE THE DAO SPECIFIC INFORMATION */
const indexMain = async () => {
    let _dao = '{{ $dao_id }}'
    let timeStart = performance.now()
    //fetch dao meta first
    dao = (await getAlldaoInfo(_dao))[_dao];  
    //load dao meta function first
    setUp('meta')
    //get onchain info
    dao = {...((await getDaoWithoutMeta([_dao]))[0]), ... dao}; 
    dao.toml = await readAssetToml(dao.url)
    setUp(); 
    inbox_link += "?dao=" + _dao + "&name=" + dao.name
    E('tab3').innerText = "Members (" + dao.members + ")"
    if (dao.admins.includes(walletAddress) || dao.owner == walletAddress) {  
        E('prop_review_tab').style.display = 'flex'
        E('add_poll_info').style.display = 'flex'
        E('add_bulletin_info').style.display = 'flex'
    }
    setTimeout(loadBulletin, 50)
    //show proposal review only if admin
    if (dao['proposals'] != undefined) {
        //load info of all the proposals
        if (dao.proposals.length > 0) {
            //get all propsoal ifo
            const props = await getAllProposal(dao.proposals, dao.token);
            if(props.status) { 
                let temPropView = document.createElement('div') //hold proposal views, till they are done loading
                let temRePropView = document.createElement('div') //hold proposal views, till they are done loading
                for(let i=0;i<dao.proposals.length;i++) {
                    const prop = props[dao.proposals[i]];  
                    if (prop != undefined && prop != "") {
                        prop.status = Number(prop.status);  
                        if (prop['title'] != undefined) {
                            prop.proposalId = dao.proposals[i]; //attach id
                            proposals[prop.proposalId] = prop
                            if (prop.status != 0 && prop.status != 2) {
                                //append 
                                prop.first = (temPropView.innerHTML == "")
                                temPropView.appendChild(drawProposal(prop))
                            }
                            //append based on review  
                            if (prop.status == 0) {
                                prop.first = (temRePropView.innerHTML == "")
                                temRePropView.innerHTML += drawProposalReview(prop)
                            }
                           
                        }
                    }
                } 
                E('proposal_views').innerHTML = temPropView.innerHTML;
                E('proposal_review').innerHTML = temRePropView.innerHTML;
                if (temPropView.firstElementChild == null) {
                    E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                    E('proposal_views').setAttribute('data', 'empty')
                }
                if (temRePropView.firstElementChild == null) {
                    E('proposal_review').innerHTML = "<div style='font-size:20px; margin:60px;'><center>Nothing found.</center></div>"
                }
                //show proposals counts
                E('tab1_count').innerHTML = "(" + temPropView.children.length + ")"
                E('tab5').innerHTML = "Proposals In Review (" + temRePropView.children.length + ")"
                temPropView = temRePropView = null
            }
        } else {
            E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
            E('proposal_review').innerHTML = "<div style='font-size:20px; margin:60px;'><center>Nothing found.</center></div>"
        }
    }
    else {
        E('proposal_views').innerHTML = "<div style='font-size:20px; margin:60px;'><center>No proposal created yet<br>Be the first to create a proposal.</center></div>"
            E('proposal_review').innerHTML =  "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
    }
    
    E('leaveDao').onclick = async () => {
        const id = talk("Getting ready")
        //first burn all the tokens
        const bal = await getTokenUserBal(dao.token, walletAddress)
        if (bal > 0) {
            talk("First burning asset balance", 'norm', id)
            //burn tokens first
            await burnToken(bal, code, issuer)
        }
        talk("Leaving Dao", 'norm', id)
        const res = await leaveDao(dao.code, dao.issuer, _dao, dao.name)
        if (res.status === true) {
            talk("You have left this Dao", 'good', id)
            //hide button
            E('leaveDao').style.display = 'none'
        } else {
            talk("Something went wrong", 'fail', id)
        }
        stopTalking(4, id)

    }
    //load users
    E('dao_users').innerHTML = `<center style='margin: 40px 20px'>Loading members</center>`
    //configure the buttons
    E('next_dao_user_info').onclick = () => {
        if (dao_users_page < daoUsers.length / dao_user_page_segment) {
            loadUsers(dao_users_page + 1)
            dao_users_page++
        }
    }
    E('pre_dao_user_info').onclick = () => {
        if (dao_users_page > 1) {
            loadUsers(dao_users_page - 1)
            dao_users_page--
        }
    }
    daoUsers = await getDaoUsersP(dao.name);
    daoDelegatee = await getDaoDelegatee(dao.token, walletAddress)
    
    setTimeout(loadUsers, 50)
    setTimeout(loadDelegatee, 50)
}
/** Load dao info 
 * @params {type all|meta|chain}
 **/
const setUp = (type = 'all') => { 
    if (dao['token'] != undefined) {
        E('dao_name').innerHTML = E('dao_name_head').innerHTML = E('dao_save_name').innerHTML = dao.name || "no name"
        E('dao_about').innerHTML = E('dao_save_about').innerHTML = dao.description || "Your friendly Lumos DAO community"
        E('dao_members').innerHTML = dao.members.toLocaleString() + (( dao.members > 1) ? " members" : " member")
        //get token info name
        E('dao_token_name').innerHTML = E('dao_save_code').innerHTML = dao.code
        E('dao_token_url').innerHTML = E('dao_token_url').href = dao.url
        const imgx = (dao.image || "");
        const coverImgx = dao.cover
        E('dao_cover_image').src = coverImgx
        E('dao_token_img').src = E('dao_save_img').src = E('dao_image').src = (dao.image || "")  + '?id=' + Math.random() * 100
        E('asset_name').href = 'https://stellar.expert/explorer/testnet/asset/' + dao.code + "-" + dao.issuer
        E('createProposal').href = E('createProposal').href.replace('PROPOSAL_CREATE',`${dao.name}:${dao['token']}`)
        E('createProposal').style.display = 'block'
        //check if ts a member of this dao
         const isMember = dao['joined']
        if (isMember !== false && dao.owner != walletAddress) {
            E('leaveDao').style.display = 'block'
        } else {
            E('leaveDao').style.display = 'none'
        }      
        //get asset info from toml
        if (dao.url != "" ) {
            const aToml = dao.toml
            if(type == 'all' || type == 'chain') {
                E('dao_website').innerHTML = E('dao_website').href = E('dao_save_domain').innerHTML = E('dao_save_domain_href').href = (aToml.DOCUMENTATION != undefined) ? aToml.DOCUMENTATION.ORG_URL : ""
                if (aToml.CURRENCIES) {
                    const temp = (dao.owner || "")
                    E('dao_others_address').innerHTML = ""
                    E('dao_others_address').appendChild(drawOtherAddress(temp, 'DAO Creator'))
    
                }
                //check if its an approved wallet
                if (dao.issuer == walletAddress || dao.admins.includes(walletAddress)) {  
                    E('dao_setting').style.display = 'block'
                    E('manageAdminBut').style.display = 'block'
                    E('manageAdminBut').addEventListener('click', () => {
                        //clear the search field
                        E('addNewAdmin').style.display = 'none'
                    })
                }
                //load approved address
                is_Admin = dao.admins.includes(walletAddress) || (dao.owner == walletAddress)
                E('dao_admin_lists').innerHTML = ""
                //load admin list
                for (let i = 0; i < dao.admins.length; i++) {
                    if (dao.admins[i] != null) {
                        E('dao_admin_lists').innerHTML += drawAdminUser({
                            user: dao.admins[i]
                        })
                        E('dao_others_address').appendChild(drawOtherAddress(dao.admins[i], "Admin"))
                    }
                }
                if (E('dao_admin_lists').innerHTML == "") {
                    E('dao_admin_lists').parentElement.style.display = 'none'
                } else {
                    E('dao_admin_lists').parentElement.style.display = ''
                }
                //show top voters
                //sort in descending order
                dao.top_voters.sort((a, b) => N(b.vote - a.vote));
                if (dao.top_voters.length > 0) {
                    E('topVotersView').innerHTML = ""
                    for (let i = 0; i < dao.top_voters.length && i < 20; i++) {
                        E('topVotersView').appendChild(drawTopVoters(dao.top_voters[i]))
                    }
                    E('topVoters').style.display = "block"
                } else {
                    E('topVotersView').innerHTML = "<center style='margin-top:40px'>Nothing to show</center>"
                }
                //display links
                const socials = aToml.DOCUMENTATION
                if (socials.ORG_TWITTER != "") {
                    E('dao_twitter').href = socials.ORG_TWITTER
                    E('dao_twitter').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_twitter').parentElement.style.display = 'none'
                }
                if(dao.twitter != "") {
                    E('dao_save_twitter_div').innerHTML = "Connected"
                    E('dao_save_twitter').disabled = true
                }
                if (socials.ORG_TELEGRAM != "") {
                    E('dao_telegram').href = socials.ORG_TELEGRAM
                    E('dao_telegram').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_telegram').parentElement.style.display = 'none'
                } //hide the icon
                if(dao.telegram != "") {
                    E('dao_save_telegram').innerHTML = `<img class="w-img border" src="{{asset('/images/download.jpeg')}}" alt="">
                    <div id='dao_save_telegram_div'  class="font-medium text-muted ml-2">Connected</div>`
                    E('dao_save_telegram').disabled = true
                }
                else {
                    //append the telegram login button
                    E('dao_save_telegram').innerHTML = "";
                    E('dao_save_telegram').appendChild(window.telegram)
                }
                if (socials.ORG_REDDIT != "") {
                    E('dao_reddit').href = socials.ORG_REDDIT
                    E('dao_reddit').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_reddit').parentElement.style.display = 'none'
                } //hide the icon
                if(dao.reddit != "") {
                    E('dao_save_reddit_div').innerHTML = "connected"
                    E('dao_save_reddit').disabled = true
                }
                
                if (socials.ORG_INSTAGRAM != "") {
                    E('dao_instagram').href = socials.ORG_INSTAGRAM
                    E('dao_instagram').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_instagram').parentElement.style.display = 'none'
                } //hide the icon
    
                if (socials.ORG_DISCORD != "") {
                    E('dao_discord').href = E('dao_save_discord').value = socials.ORG_DISCORD
                    E('dao_discord').parentElement.style.display = 'flex' //show the icon
                } else {
                    E('dao_discord').parentElement.style.display = 'none'
                } //hide the icon
            }
        }
        E('dao_save_about_edit').style.display = 'none'
        E('dao_save_about').style.display = 'block'
        E('addAdminInputField').style.display = "none" //hide the add admin input field
        E('addNewAdmin').style.display = "none" //hide the add admin input field
        E('dao_save_image_edit').value = [] //reset file upload
        E('dao_save_about_edit').value = "" //reset description
        E('dao_save_button').disabled = false //enable save button
        
    }
}
const loadDelegatee = async () => {
    if (daoDelegatee.length > 0) {
        for (let i = 0; i < daoDelegatee.length; i++) {
            if (daoDelegatee[i] != "") {
                //show
                E('user_delegates_view').innerHTML += drawDelegateSearchResult({
                    user: daoDelegatee[i],
                    type: 2
                })
            }
        }
        if (E('user_delegates_view').innerHTML != "") {
            E('user_delegates').style.display = "" //show
        }
    } else {
        E('user_delegates').style.display = "none" //hide
    }
}
const loadUsers = async (page = 1) => {
    //to do pagination, segment is 20
    const start_index = (page - 1) * dao_user_page_segment;
    const end_index = start_index + dao_user_page_segment
    //reset view
    E('dao_users').innerHTML = ""
    for (let i = start_index; i < end_index && i < daoUsers.length; i++) {
        E('dao_users').innerHTML += drawMember({
            member: daoUsers[i],
            isBan: dao.ban_members.includes(daoUsers[i])
        })
    }

    if (end_index >= daoUsers.length) {
        //hide next button
        E('next_dao_user_info').style.display = 'none'
    } else {
        E('next_dao_user_info').style.display = 'block'
    }
    if (start_index == 0) {
        //hide next button
        E('pre_dao_user_info').style.display = 'none'
    } else {
        E('pre_dao_user_info').style.display = 'block'
    }
    //handle empty voters
    if (E('dao_users').firstElementChild == null) {
        //show empty view
        E('dao_users').innerHTML = `<center style='margin: 40px 20px'>Nobody has joined this DAO yet</center>`
    }

}
const loadBulletin = async () => {
    bulletins = await getDaoBulletins(dao.token)
    paginate('bulletins_views', bulletins, 5, drawBulletinBox)
}
const showInModalView = async (bullentId, indx) => {  
    if(E(bullentId).parentElement.id != 'bulletin_modal_view') {
        const mainView = E(bullentId).parentElement
        const child = E(bullentId)
        mainView.removeChild(E(bullentId))
        E('bulletin_modal_view').appendChild(child)
        //set the dimensions
        E(bullentId).style.width = "calc(100% - 10px)"
        E(bullentId).style.marginTop = "20px !important"
        setTimeout(() => {
            E(bullentId).setAttribute('data-toggle', "")
        }, 500)
        //do timer to listen to when it goes offline
        await new Promise(resolve => setTimeout(resolve, 500))
        const tmr = setInterval(() => { 
            if(E('BulletinView').style.display == 'none') {
                //place bulletin back to its view
                const childrn = mainView.children
                if(childrn[indx] != null) {
                    //then insert at its original position
                    mainView.insertBefore(E(bullentId), childrn[indx])
                }
                else {
                    //place at the begining
                    mainView.appendChild(E(bullentId))
                }
                //reset dimensions
                E(bullentId).style.width = ""
                E(bullentId).style.marginTop = ""
                //reset attributes
                E(bullentId).setAttribute('data-toggle', "modal")
                clearInterval(tmr)
            }
        }, 50)
    }
}
//to enableEdit
const enableEdit = (type) => {
    if (type == 'image') {
        //open select image
        validateImageUpload('dao_save_image_edit', 'dao_save_img', 2, (e, url) => {
            optimizeImg(url, 0.9, 400, 400).then((img) => { 
                //update upload file
                logoSaveImg = img
            })
        }) 
        E('dao_save_image_edit').click()
        E('dao_save_button').style.display = 'block'
    } else if (type == 'about') {
        //make about div editable
        E('dao_save_about_edit').style.display = 'block'
        E('dao_save_about').style.display = 'none'
        E('dao_save_about_edit').value = E('dao_save_about').innerText
        E('dao_save_button').style.display = 'block'
    } else if (type == 'admins') {
        //show add admin input field
        E('addAdminInputField').style.display = "flex"
    }
}

//Button click
//to save the changes to the toml file
E('dao_save_button').onclick = async () => {
    //to update the dao toml file
    if (await isBanned(dao.token, walletAddress)) {
        return ""
    }
    const fileInput = E('dao_save_image_edit');
    const saveDesc = (id = null) => {
        const desc = E('dao_save_about_edit').value.trim()
        if (desc != "") {
            if (isSafeToml(desc)) {
                (id != null) ? talk("Saving description", "norm", id): id = talk("Saving description")
                modifyDao(dao.url, dao.code, 'about', desc, async (status) => {
                    if (status) {
                        talk("Description updated successfully", "good", id)
                        //resetting description input
                        E('dao_save_about_edit').value = ""
                        //hiding the input element
                        E('dao_save_about_edit').style.display = 'none'
                        E('dao_save_about').style.display = 'block'
                        E('dao_save_about').innerHTML = desc
                        //save back the results
                        dao.description = desc
                        stopTalking(3, talk("Saved successfully", 'good', id))
                    } else {
                        talk("Unable to update description<br>Something went wrong<br>This may be due to network error", "fail", id)
                        stopTalking(3, id)
                        E('dao_save_button').disabled = false
                    }
                })
            } else {
                const msg = "Invalid characters(\") present in description.<br> Please remove it and try again";
                (id != null) ? talk(msg, 'fail', id): id = talk(msg, 'fail')
                stopTalking(3, id)
                E('dao_save_button').disabled = false
            }
        } else {
            saveSocials(id)
        }

    }
    if (fileInput.files.length !== 0) {
        E('dao_save_button').disabled = true
        const id = talk("Saving new image")
        modifyAssetImg(dao.code + dao.issuer, async (status) => {
            if (status) {
                talk("Image updated successfully", "good", id)
                E('dao_save_image_edit').value = [] //resetting image upload
            } else {
                talk("Unable to modify image<br>Something went wrong<br>This may be due to network error",
                    "fail", id)
            }
            //time to mint the asset
            await new Promise((resolve) => setTimeout(resolve, 1000));
            saveDesc(id)
        })
    } else {
        saveDesc()
    }
}


//to add dao admins
E('manageAdminConfirm').onclick = async () => {
    const addr = E('dao_search_admin').value.trim()
    if (walletAddress == dao.owner) {
        if (addr != "") {
            if (addr !== dao.owner) {
                if (isSafeToml(addr)) {
                    //check if its already an admin
                    if (dao.admins.includes(addr)) {
                        stopTalking(3, talk("Already an admin", 'warn'));
                        return;
                    }
                    E('manageAdminConfirm').disabled = true
                    //call trustline function
                    const id = talk("Checking address", "norm")
                    await new Promise((resolve) => setTimeout(resolve, 500));
                    talk("Adding admin", "norm", id)
                    if ((await getTokenUserBal(dao.token, addr)) !== false) {
                        //add admin on chain
                        const res = await addAdmin({
                            admin: addr,
                            dao: dao.token,
                            daoName: dao.name
                        })
                        if (res !== false) {
                            stopTalking(3, talk("Admin added successfully", "good", id))
                            dao.admins.push(addr)
                            setUp()
                        } else {
                            talk("Unable to add admin<br>Something went wrong<br>This may be due to network error",
                                "fail", id)
                            stopTalking(3, id)
                        }
                        E('manageAdminConfirm').disabled = false
                    } else {
                        const msg =
                            "This address is not a memeber of this DAO<br>Please establish a trustline and try again";
                        stopTalking(4, talk(msg, 'fail', id))
                    }
                } else {
                    const msg =
                        "Invalid characters(\") present in the name.<br> Please remove it and try again";
                    stopTalking(4, talk(msg, 'fail'))
                }
            } else {
                const msg = "The Dao onwer is alreasy an admin";
                stopTalking(4, talk(msg, 'fail'))
            }
        } else {
            const msg = "Empty field present";
            stopTalking(4, talk(msg, 'fail'))
        }
    } else {
        const msg = "Only the owner can do this";
        stopTalking(4, talk(msg, 'fail'))
    }
}

//to oauth socials
const saveSocials = async(type, user) => {
    if(type == 'twitter') {
        const provider = new TwitterAuthProvider(); 
        const auth = getAuth();
        signInWithPopup(auth, provider)
        .then(async (result) => { 
            const user = result.user
            //save the refresh token
             try {
                 if(user.refreshToken) {
                    const id = talk('Connecting twitter')
                    //modify the toml first
                    const shareUri = 'https://x.com/' + result._tokenResponse.screenName
                    modifyDao(dao.url, dao.code, 'social', JSON.stringify({
                             twitter:shareUri
                         }), async (status) => {
                            if (status) {
                                //save back the results
                                dao.toml.DOCUMENTATION.ORG_TWITTER = shareUri
                                const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=twitter_auth&dao=" + dao.token  + "&code=" + encodeURIComponent(user.refreshToken) 
                                const response = await fetch(url);
                                if (!response.ok) {
                                  throw new Error("Network response was not ok");
                                }
                                const res = await response.json();
                                if(res.status) {
                                    dao.twitter = user.refreshToken
                                    setUp()
                                    talk("Twitter connected successfully", "good", id)
                                    stopTalking(3, id)
                                }
                                else {
                                    talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                                    stopTalking(3, id)
                                }
                            } else {
                                talk("Unable to connect twitter account<br>Something went wrong<br>This may be due to network error","fail", id)
                                stopTalking(3, id)
                            }
                    })
                }
                else {
                    stopTalking(3, talk('Something went wrong', 'fail'))
                }
            } catch (error) { console.log(error)
                stopTalking(2.5, talk("Unable to connect twitter", 'fail'))
            }
        }).catch((error) => {
          console.log(error) 
        });
    }
    else if(type == 'telegram') {
         try {
                if(user.id) {
                    const id = talk('Connecting telegram')
                    //modify the toml first
                    const shareUri = 'https://t.me/' + user.username
                    modifyDao(dao.url, dao.code, 'social', JSON.stringify({
                             telegram:shareUri
                         }), async (status) => {
                            if (status) {
                                //save back the results
                                dao.toml.DOCUMENTATION.ORG_TELEGRAM = shareUri
                                const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=telegram_auth&dao=" + dao.token  + "&id=" + encodeURIComponent(user.id) 
                                const response = await fetch(url);
                                if (!response.ok) {
                                  throw new Error("Network response was not ok");
                                }
                                const res = await response.json();
                                if(res.status) {
                                    dao.twitter = user.refreshToken
                                    setUp()
                                    talk("Telegram connected successfully", "good", id)
                                    stopTalking(3, id)
                                }
                                else {
                                    talk("Unable to connect telegram account<br>Something went wrong<br>This may be due to network error","fail", id)
                                    stopTalking(3, id)
                                }
                            } else {
                                talk("Unable to connect telegram account<br>Something went wrong<br>This may be due to network error","fail", id)
                                stopTalking(3, id)
                            }
                    })
                }
                else {
                    stopTalking(3, talk('Something went wrong', 'fail'))
                }
            } catch (error) { console.log(error)
                stopTalking(2.5, talk("Unable to connect telegram", 'fail'))
            }
    }
    else if(type == 'reddit') {
        window.location.href = getRedditOauthUri(dao.token, (new URL(dao.url).hostname.split('.')[0]))
    }
}
//to search 
const searchAdminUser = () => {
    const search = E('dao_search_admin_result')
    search.innerHTML = ""
    const addr = E('dao_search_admin').value.trim()
    if (addr != "") {
        for (let i = 0; i < daoUsers.length; i++) {
            if (daoUsers[i] == addr) {
                //present 
                search.innerHTML = drawUser({
                    user: daoUsers[i]
                })
            }
        }
        if (search.innerHTML == "") {
            search.innerHTML = ` 
                    <center style='margin:40px'>Nothing found</center> 
                    `
            E('dao_admin_rules').style.display = 'none'
        } else {
            E('dao_admin_rules').style.display = 'flex'
        }
        E('addNewAdmin').style.display = ''
    } else {
        E('addNewAdmin').style.display = 'none'
    }
}
const searchDelegate = () => {
    const _delegatee = E('dao_delegate_search').value.trim()
    E('searchDelegateResults').innerHTML = ""
    if (_delegatee != "") {
        //loop through users
        for (let i = 0; i < daoUsers.length; i++) {
            if (daoUsers[i].indexOf(_delegatee) > -1 && daoUsers[i] != walletAddress) {
                //show
                E('searchDelegateResults').innerHTML += drawDelegateSearchResult({
                    user: daoUsers[i],
                    type: (daoDelegatee.includes(daoUsers[i])) ? 2 : 1
                })
            }
        }
        if (E('searchDelegateResults').innerHTML == "") {
            E('searchDelegateResults').innerHTML = `<center style='margin: 40px 20px'>Nothing found</center>`
        }
        E('user_delegates_search').style.display = "" //show
    } else {
        E('user_delegates_search').style.display = "none" //show
    }
}

//modifications
const approveProposal = async (prop = {}, _id = "", event) => {
    //to approve a proposal
    prop = proposals[prop]
    event.stopPropagation()
    if (prop.budget > 0) {
        //budget admin
        if (walletAddress == dao.owner) {
            await aP()
        } else {
            stopTalking(3, talk("Only the DAO owner can approve a budgeted proposal", 'warn'))
        }
    } else {
        //not a budgt proposal, check if admin
        if (is_Admin) {
            await aP()
        } else {
            stopTalking(3, talk("Only the DAO owner or an admin can approve proposals", 'warn'))
        }
    }

    async function aP() {
        //actual approval
        const id = talk("Accepting proposal")
        const res = await executeProposal({
            propId: prop.proposalId,
            status: 1,
            creator:prop.creator,
            daoId:'{{ $dao_id }}',
            _type: (dao.url.indexOf('lumos') > -1) ? 2 : 1
        })
        if (res !== false) {
            if (res.status === "done") {
                talk("Proposal accepted", 'good', id)
                stopTalking(3, id)
                prop.status = 1n;
                proposals[prop.proposalId] = prop
                //draw it in the confirm section
                const elem = E('proposal_review')
                elem.removeChild(E(_id))
                E('tab5').innerHTML = "Proposals In Review (" + elem.children.length + ")"
                if (elem.firstElementChild == null) {
                    elem.innerHTML =  "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                }
                if (E('proposal_views').getAttribute('data') == 'empty') {
                    E('proposal_views').innerHTML = ""
                }
                E('proposal_views').insertBefore(drawProposal(prop), E('proposal_views').firstElementChild)
                E('tab1_count').innerHTML = "(" + E('proposal_views').children.length + ")"
                
            } else if (res.status == "lowvotes") {
                stopTalking(3, talk("Unable to accept a proposal with no votes", 'fail', id))
            } else if (res.status == "executed") {
                stopTalking(3, talk("Proposal has already been executed", 'fail', id))
            } else if (res.status == "notauth") {
                stopTalking(3, talk("You are not authorized to do this<br>You are no longer an admin",
                    'fail', id))
            } else {
                stopTalking(3, talk("Unable to approve proposal", 'fail', id))
            }
        } else {
            stopTalking(3, talk("Something went wrong", 'fail', id))
        }
    }
}
const rejectProposal = async (prop = {}, _id = "", event) => {
    //to approve a proposal
    prop = proposals[prop]
    event.stopPropagation()
    if (walletAddress == dao.owner || is_Admin) {
        await aP()
    } else {
        stopTalking(3, talk("You are not authorized to do this", 'warn'))
    }


    async function aP() {
        //actual approval
        const id = talk("Rejecting proposal")
        const res = await executeProposal({
            propId: prop.proposalId,
            status: 2,
            _type: 0,
            creator:prop.creator,
            daoId:'{{ $dao_id }}'
        })
        if (res !== false) {
            if (res.status === 'done') {
                stopTalking(3, talk("Proposal rejected", 'good', id))
                prop.status = 2n;
                prop.executed = true
                proposals[prop.proposalId] = prop
                //draw it in the confirm section
                const elem = E('proposal_review')
                elem.removeChild(E(_id))
                //set the new proposal review no
                E('tab5').innerHTML = "Proposals In Review (" + elem.children.length + ")"
                if (elem.firstElementChild == null) {
                    elem.innerHTML = "<div style='font-size:20px; margin:60px;'><center>No record found.</center></div>"
                }
            } else if (res.status == "executed") {
                stopTalking(3, talk("Proposal has already been executed", 'fail', id))
            } else if (res.status == "notauth") {
                stopTalking(3, talk("You are not authorized to do this<br>You are no longer an admin",
                    'fail', id))
            } else {
                stopTalking(3, talk("Unable to reject proposal<br>Something went wrong", 'fail', id))
            }
        } else {
            stopTalking(3, talk("Unable to reject proposal", 'fail', id))
        }
    }
}
const confirmProposal = async (prop = {}, _id = "", event) => {
    prop = proposals[prop]
    event.stopPropagation()
    if (walletAddress == dao.owner || is_Admin) {
        await aP()
    } else {
        stopTalking(3, talk("You are not authorized to do this", 'warn'))
    }
    async function aP() {
        //actual approval
        const id = talk("Confirming proposal")
        if ((await getTokenUserBal(dao.token, dao.treasury)) !== false) {
            const res = await signDaoAdmin({
                propId: prop.proposalId,
                admin: walletAddress,
                dao: dao.token
            })
            if (res !== false) {
                console.log(res)
                if (res.status === 'done') {
                    stopTalking(3, talk("Your signature has been added", 'good', id))
                    proposals[prop.proposalId].signatory.push(walletAddress)
                    proposals[prop.proposalId].signatory_count += 1;
                    if (E("prop_budget_signatory_" + prop.proposalId)) {
                        E("prop_budget_signatory_" + prop.proposalId).innerText = "(" + proposals[prop
                            .proposalId].signatory_count + "/" + (dao.admins.length + 1) + ")"
                    }
                } else if (res.status === 'transfer') {
                    stopTalking(3, talk("Proposal budget has been funded successfully", 'good', id))
                    proposals[prop.proposalId].status = 3n
                    if (E('prop_main_status_' + prop.proposalId) != null) {
                        E('prop_main_status_' + prop.proposalId).innerText = 'Funded'
                        E('prop_main_end_' + prop.proposalId).style.display = ""
                    }
                } else if (res.status == "signed") {
                    stopTalking(3, talk("You have already added your signature", 'warn', id))
                } else if (res.status == "rejected") {
                    stopTalking(3, talk("This proposal has already been rejected", 'fail', id))
                } else if (res.status == "lowfund") {
                    stopTalking(3, talk("Insufficent balance in Multi-Sig contract to fund this proposal",
                        'fail', id))
                } else if (res.status == "noadmin") {
                    stopTalking(3, talk("You are not authorized to do this<br>You are no longer an admin",
                        'fail', id))
                } else {
                    stopTalking(3, talk("Unable to confirm proposal<br>Something went wrong", 'fail', id))
                }
            } else {
                stopTalking(3, talk("Unable to confirm proposal", 'fail', id))
            }
        } else {
            talk("The proposal fund wallet has not established a trustline with the DAO token", 'fail', id)
            await new Promise((resolve) => setTimeout(resolve, 2500));
            stopTalking(3, talk("Please establish a trustline and try again", 'warn', id))
        }
    }

}
const modifyAssetImg = (assetName, callback) => {
    const fileInput = E('dao_save_image_edit');
    const formData = new FormData(); // Create a FormData object
    // Add the selected file to the FormData object
    formData.append('file', logoSaveImg);
    // Create an HTTP request
    const xhr = new XMLHttpRequest();
    const url = window.location.protocol + "//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=upload&name=" + assetName + ".png"
    // Define the server endpoint (PHP file)
    xhr.open('POST', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log(xhr.responseText)
            if (xhr.responseText == "1") {
                callback(true)
            } else {
                callback(false)
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            callback(false)
        }
    };
    // Send the FormData object with the image
    xhr.send(formData);
}
const modifyDao = (domain, assetName, type, value, callback) => {
    // Create an HTTP request
    domain = new URL(domain).hostname.split('.')[0]
    const xhr = new XMLHttpRequest();
    const url = window.location.protocol +
        `//<?php echo $_SERVER['HTTP_HOST']; ?>/.well-known/asset.php?type=modify${type}&name=` + assetName +
        "&value=" + encodeURIComponent(value) + "&domain=" + domain
    console.log(url)
    // Define the server endpoint (PHP file)
    xhr.open('POST', url, true);
    // Set up an event listener to handle the response
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if (xhr.responseText == "1") {
                callback(true)
            } else {
                callback(false)
            }
        } else if (xhr.readyState === 4 && xhr.status !== 200) {
            callback(false)
        }
    };
    // Send the FormData object with the image
    xhr.send();
}
const addUserDelegate = async (type = 1, delegatee) => {
    //to add or remove a delegate
    let id;
    const but = E(delegatee + '_delegate')
    const del_address = delegatee
    if (await isBanned(dao.token, walletAddress)) {
        stopTalking(3, talk("You have been banned from this dao", 'fail'))
        return ""
    }
    //check if user has joined the dao
    if ((await getTokenUserBal(dao.token, walletAddress)) === false) {
        stopTalking(3, talk("You are not a member of this dao", 'fail'))
        return ""
    }
    but.disabled = true  
    if (type == 1) {
        id = talk("Delegating voting power to " + fAddr(delegatee, 6))
    } else {
        id = talk("Reclaiming voting power from " + fAddr(delegatee, 6))
        delegatee = walletAddress
    }
    const res = await addDelegate({
        delegatee: delegatee,
        del_address:del_address,
        dao: dao.token
    })
    but.disabled = false
    if (res !== false) {
        if (type == 1) {
            stopTalking(3, talk("Delegated voting power to " + fAddr(delegatee, 6), 'good', id))
            daoDelegatee = [delegatee]
        } else {
            stopTalking(3, talk("Reclaimed voting power from " + fAddr(del_address, 6), 'good', id))
            daoDelegatee = []
        }
        //reload results
        loadDelegatee()
        //hide delegate search results
        E('user_delegates_search').style.display = "none"
    } else {
        if (type == 1) {
            stopTalking(3, talk("Unable to delegate voting power to " + fAddr(delegatee, 6) +
                '<br>Something went wrong', 'fail', id))
        } else {
            stopTalking(3, talk("Unable to reclaim voting power from " + fAddr(del_address, 6) +
                '<br>Something went wrong', 'fail', id))
        }
    }
}
const banMember = async (user, id, event) => {
    //to ban a member
    E(id).classList.add('d-none')
    if (is_Admin) {
        if (user != dao.owner) {
            if (user != walletAddress) {
                event.target.disabled = true
                const id = talk('Banning member ' + fAddr(user, 10))
                const res = await banDaoMember({
                    user: user,
                    dao: dao.token,
                    url: dao.url
                })
                event.target.disabled = false
                if (res.status === "true") {
                    stopTalking(3, talk("Banned member " + fAddr(user, 10), "good", id))
                    //remove from banned list
                    dao.ban_members.push(user)
                    loadUsers(1)
                } else if (res.status === "false") {
                    stopTalking(3, talk("Unable to ban member " + fAddr(user, 10) + "<br>Something went wrong",
                        "fail", id))
                } else if (res === 2) {
                    stopTalking(3, talk("Unable to perform this operation because you are not an admin", "fail",
                        id))
                } else if (res === 3) {
                    stopTalking(3, talk("Network error", "fail", id))
                } else if (res === 4) {
                    stopTalking(3, talk("Unable to perform this operation because your account has been banned",
                        "fail", id))
                } else {
                    stopTalking(3, talk("Unable to ban member " + fAddr(user, 10) + "<br>Something went wrong",
                        "fail", id))
                }
            } else {
                stopTalking(3, talk("You cannot ban yourself", "fail"))
            }
        } else {
            stopTalking(3, talk("You cannot ban the creator of this DAO", "fail"))
        }
    } else {
        stopTalking(3, talk("Only an admin can do this", "fail"))
    }
}
const unbanMember = async (user, id, event) => {
    //to ban a member
    E(id).classList.add('d-none')
    if (is_Admin) {
        if (user != walletAddress) {
            event.target.disabled = true
            const id = talk('Removing ban from member ' + fAddr(user, 10))
            const res = await unbanDaoMember({
                user: user,
                dao: dao.token,
                url: dao.url
            })
            event.target.disabled = false
            if (res.status === "true") {
                stopTalking(3, talk("Unbanned member " + fAddr(user, 10), "good", id))
                //add to  banned list
                dao.ban_members[dao.ban_members.indexOf(user)] = null
                loadUsers(1)
            } else if (res.status === "false") {
                stopTalking(3, talk("Unable to unban member " + fAddr(user, 10) + "<br>Something went wrong",
                    "fail", id))
            } else if (res === 2) {
                stopTalking(3, talk("Unable to perform this operation because you are not an admin", "fail",
                    id))
            } else if (res === 4) {
                stopTalking(3, talk("Unable to perform this operation because your account has been banned",
                    "fail", id))
            } else if (res === 3) {
                stopTalking(3, talk("Network error", "fail", id))
            } else {
                stopTalking(3, talk("Unable to unban member " + fAddr(user, 10) + "<br>Something went wrong",
                    "fail", id))
            }
        } else {
            stopTalking(3, talk("You can't unban yourself", "fail"))
        }
    } else {
        stopTalking(3, talk("Only an admin can do this", "fail"))
    }
}
const sendMessage = (user) => {
    window.location.href = inbox_link + "&to=" + user
}
const removeAdmin = async (user, event) => {
    //to remove admin
    if (walletAddress == dao.owner) {
        event.target.disabled = true
        //call trustline function
        const id = talk("Removing admin", "norm")
        //save the address to the toml
        const res = await removeDaoAdmin({
            admin: user,
            dao: dao.token,
            daoName: dao.name
        })
        if (res !== false) {
            stopTalking(3, talk("Admin removed successfully", "good", id))
            dao.admins[dao.admins.indexOf(user)] = null
            setUp()
        } else {
            talk("Unable to remove admin<br>Something went wrong<br>This may be due to network error", "fail",
                id)
            stopTalking(3, id)
        }
        event.target.disabled = false
    } else {
        const msg = "Only the owner can do this";
        stopTalking(4, talk(msg, 'fail'))
    }
}
const setTreasury = async (user, event) => {
    //to remove admin
    if (walletAddress == dao.owner) {
        event.target.disabled = true
        //call trustline function
        const id = talk("Checking address", "norm")
        await new Promise((resolve) => setTimeout(resolve, 500));
        if ((await getTokenUserBal(dao.token, user)) !== false) {
            talk('Setting as treasury', 'norm', id)
            const res = await setDaoTreasury({
                treasury: user,
                dao: dao.token
            })
            if (res !== false) {
                stopTalking(3, talk("Treasury address set successfully", "good", id))
                dao.treasury = user
                setUp()
            } else {
                talk("Unable to set treasury wallet<br>Something went wrong<br>This may be due to network error",
                    "fail", id)
                stopTalking(3, id)
            }
        } else {
            stopTalking(3, talk('This address has not established a trustline', 'fail', id))
        }
        event.target.disabled = false
    } else {
        const msg = "Only the owner can do this";
        stopTalking(4, talk(msg, 'fail'))
    }
}
const addBulletin = async () => {
    const msg = E('bulletin_msg').value.trim()
    if (msg != "") {
        const id = talk("Posting bulletin")
        const resp = await isAdmin(dao.token)
        if (resp === true) {
            const res = await sendDaoBulletin(dao.token, msg, walletAddress)
            if (res.status) {
                stopTalking(3, talk("Bulletin posted successfully", 'good', id))
                //add to the bulletins data
                bulletins.unshift({
                    msg: msg,
                    date: (new Date()).getTime(),
                    user: walletAddress,
                    bid: res.id,
                    likes: 0,
                    dislikes: 0,
                    my_likes: false,
                    my_dislikes: false,
                    type: 'bulletin',
                    comments: 0,
                })
                //redo pagination
                paginate('bulletins_views', bulletins, 5, drawBulletinBox)
            } else {
                stopTalking(3, talk("Something went wrong", 'fail', id))
            }
        } else if (resp === false) {
            stopTalking(3, talk("You are not authorized to do this", 'fail', id))
        } else {
            stopTalking(3, talk("Network error", 'fail', id))
        }
    }
}
const likeBulletin = async (id, indx) => {
    //to toggle between like and dislike
    const res = await likeDaoBulletin(id, walletAddress)
    if (res.status) {
        //get like type
        if (res.type === 1) {
            //liked
            bulletins[indx].likes += 1
            bulletins[indx].dislikes = (bulletins[indx].dislikes > 0) ? bulletins[indx].dislikes - 1 : 0;
            bulletins[indx].my_likes = true
            bulletins[indx].my_dislikes = false
            if (E('likes_' + id)) {
                E('likes_' + id).innerText = fNum(bulletins[indx].likes)
                E('likes_icon_' + id).classList.add("like-active")
                E('dislikes_' + id).innerText = fNum(bulletins[indx].dislikes)
                E('dislikes_icon_' + id).classList.remove("like-active")
            }
        } else {
            bulletins[indx].likes = (bulletins[indx].likes > 0) ? bulletins[indx].likes - 1 : 0;
            bulletins[indx].my_likes = false
            if (E('likes_' + id)) {
                E('likes_' + id).innerText = fNum(bulletins[indx].likes)
                E('likes_icon_' + id).classList.remove("like-active")
            }
        }
    }
}
const dislikeBulletin = async (id, indx) => {
    //to toggle between like and dislike
    const res = await dislikeDaoBulletin(id, walletAddress)
    if (res.status) {
        //get like type
        if (res.type === 1) {
            //liked
            bulletins[indx].dislikes += 1
            bulletins[indx].likes = (bulletins[indx].likes > 0) ? bulletins[indx].likes - 1 : 0;
            bulletins[indx].my_dislikes = true
            bulletins[indx].my_likes = false
            if (E('likes_' + id)) {
                E('likes_' + id).innerText = fNum(bulletins[indx].likes)
                E('likes_icon_' + id).classList.remove("like-active")
                E('dislikes_' + id).innerText = fNum(bulletins[indx].dislikes)
                E('dislikes_icon_' + id).classList.add("like-active")
            }
        } else {
            bulletins[indx].dislikes = (bulletins[indx].dislikes > 0) ? bulletins[indx].dislikes - 1 : 0;
            bulletins[indx].my_dislikes = false
            if (E('dislikes_' + id)) {
                E('dislikes_' + id).innerText = fNum(bulletins[indx].dislikes)
                E('dislikes_icon_' + id).classList.remove("like-active")
            }
        }
    }
}
const showBulletinComment = async (id, indx) => {
    E('comment_box_' + id).classList.toggle('d-none')
    E('comment_' + id).classList.toggle('d-none')
    if (!E('comment_' + id).classList.contains('d-none')) {
        E('comment_' + id).innerHTML = '<center class="font-xs" style="margin-top:20px">Loading comments..</center>'
        let commt = await getBulletinComment(id)
        paginate('comment_' + id, commt, 5, drawBulletinCommentBox)
        //do the send comment button
        E('comment_send_' + id).onclick = async () => {
            const msg = E('comment_input_' + id).value.trim()
            if (msg != "") {
                const idx = talk('Sending comment')
                const res = await sendBulletinComment(id, msg, walletAddress)
                if (res === 1) {
                    stopTalking(3, talk('Comment sent', 'good', idx))
                    //draw it
                    commt.unshift({
                        msg: msg,
                        date: (new Date()).getTime(),
                        user: walletAddress,
                        bid: id
                    })
                    paginate('comment_' + id, commt, 5, drawBulletinCommentBox)
                    bulletins[indx].comments += 1;
                    if (E('comment_num_' + id)) {
                        E('comment_num_' + id).innerText = fNum(commt.length)
                    }
                } else if (res === 0) {
                    stopTalking(3, talk('Something went wrong', 'fail', idx))
                } else {
                    stopTalking(3, talk('Network error', 'good', idx))
                }
            }
        }
    }
}
const addNewPollOption = async () => {
    //get the current index
    const indx = E('pollForm').getAttribute('data') * 1
    if (indx >= 2 && indx < 4) {
        E('pollForm').insertBefore(drawNewPollOption(indx + 1), E('addOption'))
        E('pollForm').setAttribute('data', indx + 1)
    }
}
const addNewPoll = async (e) => {
    const msg = E('poll_question').value.trim()
    if (msg != "") {
        //fecth the poll options
        const indx = E('pollForm').getAttribute('data') * 1
        let poll = {};
        let poll_value;
        let n = 0;
        for (let i = 1; i <= indx; i++) {
            if (E('poll_option_value_' + i)) {
                poll_value = E('poll_option_value_' + i).value.trim()
                if (poll_value != "") {
                    poll[n] = poll_value;
                    n++
                }
            }
        }
        poll['num'] = n
        if (n > 1) {
            const id = talk("Posting poll")
            const resp = await isAdmin(dao.token)
            if (resp === true) {
                const res = await sendDaoBulletin(dao.token, msg, walletAddress, poll)
                if (res.status) {
                    stopTalking(3, talk("poll posted successfully", 'good', id))
                    //add to the bulletins data
                    poll = {};
                    n = 0
                    for (let i = 1; i <= indx; i++) {
                        if (E('poll_option_value_' + i)) {
                            poll_value = E('poll_option_value_' + i).value.trim()
                            if (poll_value != "") {
                                poll[n] = {
                                    value: poll_value,
                                    votes: 0,
                                    voted: false,
                                    percent: 0,
                                };
                                n++
                            }
                        }
                    }
                    poll['num'] = n
                    bulletins.unshift({
                        msg: msg,
                        date: (new Date()).getTime(),
                        user: walletAddress,
                        bid: res.id,
                        likes: 0,
                        dislikes: 0,
                        my_likes: false,
                        my_dislikes: false,
                        type: 'poll',
                        polls: poll
                    })
                    //redo pagination
                    paginate('bulletins_views', bulletins, 5, drawBulletinBox)
                    E('poll_cancel').click()
                } else {
                    stopTalking(3, talk("Something went wrong", 'fail', id))
                }
            } else if (resp === false) {
                stopTalking(3, talk("You are not authorized to do this", 'fail', id))
            } else {
                stopTalking(3, talk("Network error", 'fail', id))
            }
        } else {
            stopTalking(3, talk("Add at least two options", 'warn'))
        }
    }

}
const votePoll = async (id, pid, indx, event) => {
    event.stopPropagation();
    //to toggle between like and dislike
    const res = await voteDaoPoll(id, pid, walletAddress)
    if (res.status) {
        //get like type
        if (res.type === 'done') {
            //liked
            bulletins[indx].poll = res.polls
            //display results
            if (E('poll_bar_option_' + id + '_' + pid)) {
                E('poll_bar_option_' + id + '_' + pid).style.width = res.polls[pid].percent + '%'
                E('poll_bar_option_' + id + '_' + pid).style.background = "#8ac5fe"
                E('poll_bar_option_value_' + id + '_' + pid).innerText = res.polls[pid].percent + '%'
                E('poll_bar_option_icon_' + id + '_' + pid).style.display = "inline"
            }
        } else if (res.type === 'voted') {
            stopTalking(2, talk('Already voted', 'warn'))
        }
    }
}

const embedTweet = async () => {
    const tweet_url = E('tweet_url').value.trim()
    if (tweet_url != "") {
        const id = talk('Embedding tweet')
        const res = await embedDaoTweet(dao.token, tweet_url, walletAddress)
        if (res.status === true) {
            stopTalking(3, talk('Embedded', 'good', id))
            tweets.unshift({
                html: res.html
            })
            paginate('tweets_views', tweets, 10, drawTweetBox, () => {
                //calls after every load
                twttr.widgets.load(E('tweets_views'))
            })
            E('tweet_url').value = ""

        } else if (res.status === false) {
            stopTalking(3, talk('Something went wrong', 'fail', id))
        } else {
            stopTalking(3, talk('Network error', 'fail', id))
        }
    }
}
//Listen for modal up and reload details
const observer = new MutationObserver((mutationsList, observer) => {
    for (const mutation of mutationsList) {
        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
            // Check if the 'display' property has changed
            const currentDisplay = E('DaoSetting').style.display;
            if (currentDisplay === 'none') {
                setUp()
            } else {
                setUp()
            }
        }
    }
});
// Start observing the target element
observer.observe(E('DaoSetting'), {
    attributes: true,
    attributeFilter: ['style']
});

//draws
const drawProposal = (prop) => {
    let _div = document.createElement('div')
    let n = prop.creator.substring(0, 4) + "..." + prop.creator.substring(prop.creator.length - 5)
    let h = (prop.yes_votes + prop.no_votes) + (((prop.yes_votes + prop.no_votes) > 1) ? " members" : " member")
    let voteYesRes = N(prop.yes_votes) * (N(prop.yes_voting_power) / (floatingConstant))
    let voteNoRes = N(prop.no_votes) * (N(prop.no_voting_power) / (floatingConstant))
    //calculate yes and no votes bar
    const tmp = (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant))) + (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))
    let yes_per = (Math.floor((100 / (tmp)) * (N(prop.yes_votes) * (N(prop.yes_voting_power)/(floatingConstant)))) + "%") || "0%"
    let no_per = (Math.floor((100 / (tmp)) * (N(prop.no_votes) * (N(prop.no_voting_power)/(floatingConstant)))) + "%") || "0%"
    if(tmp == 0) {
       yes_per = '0%'
       no_per = '0%'
    }
    let _link = "{{ route('dao.proposal', ['proposal_id' => " ", "dao_id"=> $dao_id]) }}"
    _link = _link.substring(0, _link.lastIndexOf("/") + 1)
    _div.innerHTML = `
                        <div class="col-12 ${(!prop.first) ? 'border-top" style="margin-top:10px"'  : "" }">
                            <a href="${_link + prop.proposalId}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center cardEndDetail_container">
                                        <div class="cardEndDetail">
                                            <div class="text d-flex align-items-center justify-content-start gap-1">Created by:
                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="Profile Image" class="image w-img m-0 ml-2">
                                            ${n}</div>
                                        </div>
                                    <div class="small-card">
                                    <div id='prop_main_status_${prop.proposalId}' class="small-card-text 
                                    ${(prop.status == 4) ? 'text-black' : (prop.status == 0) ? 'text-muted' : (prop.status == 1) ? 'text-success' : (prop.status == 2) ? 'text-danger' : 'text-black'}">
                                    ${(prop.status == 4) ? "Ended" : (prop.status == 0) ? "Inactive" : (prop.status == 1) ? "Active": (prop.status == 2) ? "Rejected" : "Funded"}
                                    </div>
                                    </div>
                                </div>
                                <div class="cardendHeading">
                                    <h2 class="heading">${prop.title}</h2>
                                    <div class="paragraph">
                                        <p class="pb-0 line-climb-3">${prop.description}</p>
                                    </div>
                                </div>
                                <div class="my-2">
                                <div class="option mx-0 option-1">
                                        <div class="">
                                            <div class="bar" style="background:#02C17C;width:${yes_per}"></div>
                                            <div class="percent">${yes_per}</div>
                                        </div>
                                        <div class="input">
                                            <input class="poll-input" type="radio" id="option-1" name="option" hidden>
                                            <label  class="option-lable text-left font-sm" for="option-1">Yes<i
                                                    class="fa fa-check tick" aria-hidden="true"></i></label>
                                        </div>
                                </div>
                                <div class="option mx-0 option-1">
                                        <div class="">
                                            <div class="bar" style="background:#02C17C;width:${no_per}"></div>
                                            <div class="percent">${no_per}</div>
                                        </div>
                                        <div class="input">
                                            <input class="poll-input" type="radio" id="option-1" name="option" hidden>
                                            <label class="option-lable text-left font-sm" for="option-1">No<i
                                                    class="fa fa-check tick" aria-hidden="true"></i></label>
                                        </div>
                                </div>
                                </div>
                                <div class="carendBottom d-flex align-items-center justify-content-between">
                                <div class="text d-flex align-items-center justify-content-start gap-1">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" class="text-info" width="1.5em" height="1.5em" viewBox="0 0 512 512"><path fill="currentColor" d="M63.28 202a15.29 15.29 0 0 1-7.7-2a14.84 14.84 0 0 1-5.52-20.46C69.34 147.36 128 72.25 256 72.25c55.47 0 104.12 14.57 144.53 43.29c33.26 23.57 51.9 50.25 60.78 63.1a14.79 14.79 0 0 1-4 20.79a15.52 15.52 0 0 1-21.24-4C420 172.32 371 102 256 102c-112.25 0-163 64.71-179.53 92.46A15 15 0 0 1 63.28 202"/><path fill="currentColor" d="M320.49 496a15.31 15.31 0 0 1-3.79-.43c-92.85-23-127.52-115.82-128.93-119.68l-.22-.85c-.76-2.68-19.39-66.33 9.21-103.61c13.11-17 33.05-25.72 59.38-25.72c24.48 0 42.14 7.61 54.28 23.36c10 12.86 14 28.72 17.87 44c8.13 31.82 14 48.53 47.79 50.25c14.84.75 24.59-7.93 30.12-15.32c14.95-20.15 17.55-53 6.28-82C398 228.57 346.61 158 256 158c-38.68 0-74.22 12.43-102.72 35.79c-23.59 19.35-42.28 46.67-51.28 74.75c-16.69 52.28 5.2 134.46 5.41 135.21A14.83 14.83 0 0 1 96.54 422a15.39 15.39 0 0 1-18.74-10.6c-1-3.75-24.38-91.4-5.1-151.82c21-65.47 85.81-131.47 183.33-131.47c45.07 0 87.65 15.32 123.19 44.25c27.52 22.5 50 52.72 61.76 82.93c14.95 38.57 10.94 81.86-10.19 110.14c-14.08 18.86-34.13 28.72-56.34 27.65c-57.86-2.9-68.26-43.29-75.84-72.75c-7.8-30.22-12.79-44.79-42.58-44.79c-16.36 0-27.85 4.5-35 13.82c-9.75 12.75-10.51 32.68-9.43 47.14a152.44 152.44 0 0 0 5.1 29.79c2.38 6 33.37 82 107.59 100.39a14.88 14.88 0 0 1 11 18.11a15.36 15.36 0 0 1-14.8 11.21"/><path fill="currentColor" d="M201.31 489.14a15.5 15.5 0 0 1-11.16-4.71c-37.16-39-58.18-82.61-66.09-137.14V347c-4.44-36.1 2.06-87.21 33.91-122.35c23.51-25.93 56.56-39.11 98.06-39.11c49.08 0 87.65 22.82 111.7 65.89c17.45 31.29 20.91 62.47 21 63.75a15.07 15.07 0 0 1-13.65 16.4a15.26 15.26 0 0 1-16.79-13.29A154 154 0 0 0 340.43 265c-18.64-32.89-47-49.61-84.51-49.61c-32.4 0-57.75 9.75-75.19 29c-25.14 27.75-30 70.5-26.55 98.78c6.93 48.22 25.46 86.58 58.18 120.86a14.7 14.7 0 0 1-.76 21.11a15.44 15.44 0 0 1-10.29 4"/><path fill="currentColor" d="M372.5 446.18c-32.5 0-60.13-9-82.24-26.89c-44.42-35.79-49.4-94.08-49.62-96.54a15.27 15.27 0 0 1 30.45-2.36c.11.86 4.55 48.54 38.79 76c20.26 16.18 47.34 22.6 80.71 18.85a15.2 15.2 0 0 1 16.91 13.18a14.92 14.92 0 0 1-13.44 16.5a187 187 0 0 1-21.56 1.26m25.68-397.39C385.5 40.54 340.54 16 256 16c-88.74 0-133.81 27.11-143.78 34a11.59 11.59 0 0 0-1.84 1.4a.36.36 0 0 1-.22.1a14.87 14.87 0 0 0-5.09 11.15a15.06 15.06 0 0 0 15.31 14.85a15.56 15.56 0 0 0 8.88-2.79c.43-.32 39.22-28.82 126.77-28.82S382.58 74.29 383 74.5a15.25 15.25 0 0 0 9.21 3a15.06 15.06 0 0 0 15.29-14.89a14.9 14.9 0 0 0-9.32-13.82"/></svg></span>
                                        <span>Proposal ID:</span>
                                        <span>PROP_${prop.proposalId}</span>
                                </div>
                                <div id='prop_main_end_${prop.proposalId}' class="small-card" style='display:${(prop.status != 1 && prop.status != 0) ? "" : "none"}'>
                                    <img src="{{ asset('images/Layer 13.png') }}" alt="Small Image" class="small-image">
                                    <div class="small-card-text">${(voteYesRes > voteNoRes) ? "Yes" : "No"}</div>
                                </div>
                                <div class="text d-flex align-items-center justify-content-start gap-1">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 14 14"><path fill="currentColor" fill-rule="evenodd" d="m7.164 6.327l2.262-2.262a.5.5 0 0 0 0-.707L6.422.354a.5.5 0 0 0-.707 0L3.453 2.615a.5.5 0 0 0 0 .708l3.004 3.004a.5.5 0 0 0 .707 0m-4.892-.69h1.727l1.512 1.511h-1.22a.625.625 0 0 0 0 1.25h4.87a.625.625 0 0 0 0-1.25H8.11l1.511-1.512h1.557a1.5 1.5 0 0 1 1.5 1.5v2.617H.772V7.136a1.5 1.5 0 0 1 1.5-1.5Zm10.407 5.366H.772v2.47a.5.5 0 0 0 .5.5h10.907a.5.5 0 0 0 .5-.5z" clip-rule="evenodd"/></svg></span>
                                        <span>Voted by:</span>
                                       <span>${h}</span>
                                </div>
                            </div>
                            </a>
                </div>`
    return _div.firstElementChild

}
const drawProposalReview = (prop) => {
    const id = `prop_review_${prop.proposalId}`
    let _link = "{{ route('dao.proposal', ['proposal_id' => " ", "dao_id"=> $dao_id]) }}"
    _link = _link.substring(0, _link.lastIndexOf("/") + 1)
    
    return `<div id='${id}' class="col-12 p-3 ${(!prop.first) ? 'border-top' : "" }">
                                        <a onclick="window.location = '${_link + prop.proposalId}'" class="text-decoration-none">
                                            <div
                                                class="d-flex justify-content-between align-items-md-center cardEndDetail_container">
                                                <div class="text">
                                                    <span>Created by:</span>
                                                    <span>${fAddr(prop.creator, 5)}</span>
                                                </div>

                                                <div class="text">
                                                    <span>Proposal ID:</span>
                                                    <span>PROP_${prop.proposalId}</span>
                                                </div>

                                                <div class="small-card">
                                                    <div class="small-card-text">Pending</div>
                                                </div>
                                            </div>
                                            <div class="cardendHeading">
                                                <h2 class="heading">${prop.title}</h2>
                                                <div class="paragraph">
                                                    <p>
                                                        ${prop.description}
                                                    </p>
                                                </div>
                                            </div>
                                            <div>

                                            </div>
                                            <div
                                                class="carendBottom d-flex align-items-center justify-content-between w-100">
                                                <div class="d-flex align-items-center justify-content-end gap-3 ${(!is_Admin) ? 'd-none' : ""}">
                                                    <button onclick='approveProposal("${prop.proposalId}", "${id}", event)' type="button"
                                                        class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                        Approve
                                                    </button>
                                                    <button onclick='rejectProposal("${prop.proposalId}", "${id}", event)' type="button"
                                                        class="btn btn-danger text-white text d-flex align-items-center gap-2 mb-0">
                                                        Reject
                                                    </button>
                                                </div>
                                                <div class="text">
                                                    <span>Voted by: ${(prop.yes_votes + prop.no_votes)}</span>
                                                    <span>${((prop.yes_votes + prop.no_votes)  > 1) ? " members" : " member"}</span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                            `
}
const drawAddress = (addr, name = "") => {
    let tm = document.createElement('div')
    tm.innerHTML = `<div class="column-content">${name}<br><span>${fAddr(addr, 8)}</span></div>`
    return tm.firstElementChild
}
const drawOtherAddress = (addr, addrName) => {
    let tm = document.createElement('div')
    tm.innerHTML = `<div class="col-lg-4 col-md-12 col-sm-12">
                    <strong class="text-success" style='text-transform:capitalize'>${addrName}</strong>
                    <div class="column-content">
                        <p>${fAddr(addr)}</p>
                    </div>
                </div>`
    return tm.firstElementChild
}
const drawTopVoters = (param = {
    voter: "",
    vote: ""
}) => {
    let tm = document.createElement('div')
    tm.innerHTML = ` <div class="d-flex justify-content-between align-items-baseline py-2">
                                <div class="proposal_sideCard_banner">
                                    <img src="https://images.unsplash.com/photo-1682685797661-9e0c87f59c60?ixlib=rb-4.0.3&ixid=M3wxMjA3fDF8MHxlZGl0b3JpYWwtZmVlZHwxfHx8ZW58MHx8fHx8&auto=format&fit=crop&w=500&q=60" alt="">
                                    <span class="">By ${fAddr(param.voter, 6)}</span>
                                </div>
                                <div class="proposal_status-SideCard">
                                    <h2 class="heading">${param.vote}</h2>
                                </div>
                        </div>`
    return tm.firstElementChild
}
const drawUser = (params) => {
    return `<div class="d-flex flex-column flex-md-row align-items-start align-md-items-center gap-1 w-100">
                                <img class="w-img" src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="">
                                <p id='dao_search_admin_found' class="mb-0  column-content text-truncate text-break text-wrap">
                                ${fAddr(params.user, 14)}</p>
                            </div>`
}
const drawAdminUser = (params) => {
    return `<div
                      class="border rounded-md py-1 px-2 d-flex align-items-center justify-content-start position-relative flex-grow-1 gap-3">
                      <img class="w-img"
                        src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png" alt="">
                      <div class="font-normal text-secondary ml-2 font-xs">${fAddr(params.user, 10)}</div>
                      <div class="position-absolute cross-dao-setting" onclick='removeAdmin("${params.user}", event)'>
                        <svg class="text-danger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                          fill="currentColor" width="20px" heigth="20px">
                          <path fill-rule="evenodd"
                            d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                            clip-rule="evenodd" />
                        </svg>
                      </div>
                    </div>`
}
const drawMember = (params) => {
    const sFlg = (dao.owner == walletAddress && (walletAddress == params.member))
    return ` <div id="" class="d-flex justify-content-between">
                                            <div class="cardEndDetail d-flex justify-content-between gap-3">
                                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                    alt="Profile Image" class="image w-img">
                                                <div class="text text-center">
                                                    ${params.member}
                                                </div> 
                                            </div>
                                            <div class="member-ban-ctn" style='${(sFlg) ? 'display:none':"" }'>
                                                <button id="memBan-btn_${params.member}" onclick='toggleMemberModal("memBan-btn_${params.member}", "member-ban_${params.member}", event)' class="btn p-0">
                                                    <div class="text text-muted">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            width="20px" height="20px">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                                        </svg>
                                                    </div>
                                                </button>
                                                <div class="member-ban-modal d-none" id='member-ban_${params.member}'>
                                                    <button onclick='${(params.isBan) ? 'unbanMember("'+ params.member + '", "member-ban_' + params.member + '", event)' : 'banMember("'+ params.member + '", "member-ban_' + params.member + '", event)' }' class="btn" 
                                                    style='${((dao.admins.includes(params.member) || dao.owner == params.member) || (walletAddress == params.member)) ? 'display:none':"" }'>
                                                        ${(params.isBan) ? "Unban member" : "Ban member"}
                                                    </button>
                                                    <button onclick='sendMessage("${params.member}")' class="btn" style='${(walletAddress == params.member) ? 'display:none':"" }'>Messeage</button>
                                                </div>
                                            </div>
                                        </div>`

}
const drawDelegateSearchResult = (param) => {
    return `<div class="d-flex justify-content-between">
                                                <div class="cardEndDetail">
                                                    <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                        alt="Profile Image" class="image">
                                                    <div class="text text-center">${fAddr(param.user, 14)}
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button id='${param.user}_delegate' onclick='addUserDelegate(${param.type}, "${param.user}")' type="button"
                                                        class="btn btn-success text-white text d-flex align-items-center gap-2 mb-0">
                                                        ${(param.type == 1) ? "Confirm delegation" : "Reclaim delegation"}
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                            fill="currentColor" width="20px" height="20px">
                                                            <path fill-rule="evenodd"
                                                                d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                    </button>
                                            </div>
                                            </div>`
}
const drawBulletinBox = (param, indx) => {
    if (param.type == 'bulletin') {
        return `<div id='bulletin_box_${param.bid}' type="button" data-toggle="modal"  data-target="#BulletinView" onclick='showInModalView("bulletin_box_${param.bid}", ${indx})' class="d-inline btn p-0 m-0" style='margin-bottom:20px !important;'>
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="cardEndDetail gap-2">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                    alt="Profile Image" class="image w-img">
                                <div class="text text-center font-xxs text-secondary text-left">${fAddr(param.user, 6)}</div>
                            </div>
                            <div class="text font-xxs">${fDate(param.date)}</div>
                        </div>
                        <div class="bultin_description text w-100 mx-auto">
                            <p class="font-xs mb-0 overflex-hidden line-climb-3 text-left">${param.msg}</p>
                        </div>
                        <div class="d-flex align-items-center justify-content-start gap-3 bullet-icon m-0">
                            <button onclick='likeBulletin("${param.bid}", ${indx})'
                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start" style='gap:5px'>
                                <span class="font-xs" id="likes_${param.bid}">${fNum(param.likes)}</span>
                                <i id="likes_icon_${param.bid}" class="fa fa-thumbs-o-up font-sm ${(param.my_likes == true) ? 'like-active' : ''}"></i>
                                <span class="text text-secondary font-xxs text-left">Like</span>
                            </button>
                            <button onclick='dislikeBulletin("${param.bid}", ${indx})'
                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start" style='gap:5px'>
                                <span class="font-xs" id="dislikes_${param.bid}">${fNum(param.dislikes)}</span>
                                <i id="dislikes_icon_${param.bid}" class="fa fa-thumbs-o-down font-sm ${(param.my_dislikes == true) ? 'like-active' : ''}"></i>
                                <span class="text text-secondary font-xxs text-left">Dislike</span>
                            </button>
                            <button onclick='showBulletinComment("${param.bid}", ${indx})'
                                class="border-0 bg-transparent bullet-icon-i d-flex align-items-center justify-content-start" style='gap:5px'>
                                <span class="font-xs" id="comment_num_${param.bid}">${fNum(param.comments)}</span>
                                <i id="" class="fa fa-comment-o font-xs"></i>
                                <span class="text text-secondary font-xxs text-left">Comment</span>
                            </button>
                        </div>
                    <!-- comment section -->
                    <div id='comment_${param.bid}' class='d-none' style='flex-direction:column'></div>
                                    <div id="comment_box_${param.bid}" style="width: 90%; margin-right:auto;margin-left:auto;"
                                        class="d-flex align-items-end gap-4 mt-5 d-none">
                                        <div class="form-group w-100">
                                            <div class="form-control d-flex align-items-center justify-content-between">
                                                <input id="comment_input_${param.bid}" type="text" placeholder="Comment...."
                                                    class="border-0 bg-transparent text w-100 h-100 font-xs" >
                                                <button id="comment_send_${param.bid}" type="button" class="btn border-0 mb-1" style='padding:0px !important'>
                                                    <svg class="text-secondary" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="m2 21l21-9L2 3v7l15 2l-15 2z" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                    </div> `
    } else {
        //poll type
        let polls = ""
        for (let i = 0; i < param.polls.num * 1; i++) {
            polls += `<div class="option mx-0 option-${i+1}">
                                        <div class="analytic">
                                            <div id='poll_bar_option_${param.bid}_${i}' class="bar" style='width:${param.polls[i].percent}%;background:skyblue'></div>
                                            <div id='poll_bar_option_value_${param.bid}_${i}' class="percent">${param.polls[i].percent}%</div>
                                        </div>
                                        <div class="input" onclick='votePoll("${param.bid}", "${i}",  ${indx}, event)'>
                                            <input class="poll-input" type="radio" id="option-${i+1}" name="option" hidden>
                                            <label class="option-lable text-left font-xxs" for="option-1">${i+1}. ${param.polls[i].value}<i
                                            id='poll_bar_option_icon_${param.bid}_${i}' class="fa fa-check tick" aria-hidden="true" style='display:${(param.polls[i].voted) ? 'inline' : 'none'}'></i></label>
                                        </div>
            </div>`
        }
        return `<button data-toggle="modal"  data-target="#BulletinView" id='bulletin_box_${param.bid}' onclick='showInModalView("bulletin_box_${param.bid}", ${indx})'  type="button" class="d-inline btn p-0 m-0" style='margin-bottom:20px !important;'>
                        <div class="row mx-0">
                            <div class="poll-card cardEndDiv p-0">
                                <div>
                                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                                        <div class="cardEndDetail gap-2">
                                            <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                                alt="Profile Image" class="image w-img">
                                            <div class="text-center font-xxs text-secondary text-left">${fAddr(param.user, 6)}</div>
                                        </div>
                                        <div class="font-xxs">${fDate(param.date)}</div>
                                    </div>
                                    <div class="bultin_description text w-100 mx-auto">
                                            <p class="font-xs mb-0 overflex-hidden line-climb-3 text-left">${param.msg}</p>
                                    </div>
                                </div>
                                <div class="options">
                                ${polls}
                                </div>
                            </div>
                        </div>
                    </button>`
    }
}
const drawBulletinCommentBox = (param, indx) => {
    return `<div class="d-inline btn p-0 m-0" style='margin-top:10px !important;margin-left:10px !important; width:calc(100% - 10px)'>
                        <div class="d-flex flex-wrap justify-content-between align-items-center">
                            <div class="cardEndDetail gap-2">
                                <img src="https://id.lobstr.co/GBZZV4WEUL25WZMQOYTP3I7N33TJ7WYG5TTHALHA66MWEFRB2EVDRW5P.png"
                                    alt="Profile Image" class="image w-img">
                                <div class="text text-center font-xxs text-secondary text-left">${fAddr(param.user, 6)}</div>
                            </div>
                            <div class="text font-xxs">${fDate(param.date)}</div>
                        </div>
                        <div class="bultin_description text w-100 mx-auto">
                            <p class="font-xs mb-0 overflex-hidden line-climb-3 text-left">${param.msg}</p>
                        </div></div>`
}
const drawNewPollOption = (indx) => {
    let tm = `<div id='poll_option_${indx}' class="poll-option d-flex align-items-center justify-content-between gap-2">
                        <input class="pollingInput form-control h-auto w-50" type="text" id="poll_option_value_${indx}"  name="option_${indx}" placeholder="Option ${indx}" required>
                        <span onclick='E("pollForm").removeChild(E("poll_option_${indx}"))' class='text-danger' style='margin-left:10px'><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width='20px' hieght='20px'><path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" /></svg></span>
            </div>`
    let tmp = document.createElement('div')
    tmp.innerHTML = tm
    return tmp.firstElementChild
}
const drawTweetBox = (param, indx) => {
    return param.html
}
indexMain() //run the main function
</script>
@endsection
