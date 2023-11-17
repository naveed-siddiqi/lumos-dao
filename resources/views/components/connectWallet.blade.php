    <!-- bootstarp 5 js -->
    <div class="modal fade" id="ConnectWallet" {{-- {{ !isset($_COOKIE['public']) ? 'data-bs-backdrop=static data-bs-keyboard=false' : '' }} --}} tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modal-wallet">
                {{-- <a href="{{ url('wallet/disconnect') }}" class="text-danger remove-btn"
                    style="position: absolute;z-index: 1;top: 5%;right: 4%;text-decoration:none;{{ isset($_COOKIE['public']) ? '' : 'display:none' }}">Remove
                    Wallet</a> --}}
                <div class="modal-header">
                    <h5 class="modal-title">Connect Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3>Please Connect Your
                                Account to Wallet</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            <!-- Dropdown -->
                            <label class="drop">
                                <input type="checkbox" id="mainWalletList"> <!-- Toggle Drop -->
                                <span id="selectedWallet" class="control">
                                <span class="text-muted" wallet="frighter"><img
                                                src="{{ asset('images/frighter.png') }}">Frighter</span>
                                </span> <!-- Fake button -->

                                <!-- Items -->
                                <ul class="drop-items " id="walltetList">
                                    <li class="item-drop wallet-drop-items d-none">
                                        <a href="#" wallet="rabet"><img src="{{ asset('images/rabet.png') }}">
                                            Rabet</a>
                                    </li>
                                    <li class="item-drop wallet-drop-items d-none">
                                        <a href="#" wallet="frighter"><img
                                                src="{{ asset('images/frighter.png') }}">Frighter</a>
                                    </li>
                                    <li class="item-drop wallet-drop-items d-none">
                                        <a href="#" wallet="albeto"><img
                                                src="{{ asset('images/albeto.png') }}">Albedo</a>
                                    </li>
                                    <li class="item-drop wallet-drop-items d-none">
                                        <a href="#" wallet="xbull"><img
                                                src="{{ asset('images/xbull.png') }}">Xbull</a>
                                    </li>
                                    {{-- <li class="item-drop wallet-drop-items">
                                        <a href="#" wallet="privatekey"><img class=""
                                                src="{{ asset('images/privatekey.png') }}">Private Key</a>
                                    </li> --}}
                                </ul>

                                <!-- Alternative to close dropdown with click out -->
                                <label for="target-drop-example" class="overlay-close"></label>

                            </label>
                            <div class="w-100">
                                <div class="input-group-prepend">
                                    <input id="walletPrivateKey" style="display: none" type="text"
                                        class="form-control" placeholder="Secret Key">
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="cont-btn">
                                            <a type="button"
                                                class="walletconnect-btn btn dope mt-0"
                                                href="javascript::void()" onclick="connectWallet()">Connect
                                                Wallet</a>
                                            <a type="button" style="display:none"
                                                class="connectLoading-btn btn dope mt-0"
                                                href="javascript::void()">Connecting... </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END -- Dropdown -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
