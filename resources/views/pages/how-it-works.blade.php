@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <style>
                            body {
                                font-family: Arial, Helvetica, sans-serif;
                            }

                            li {
                                font-size: 16px;
                            }
                        </style>
                        </head>

                        <body>

                            <h1>How it works</h1>
                            <br>
                            <br>
                            <h3>For DAO Creators</h3>
                            <ol>
                                <li><b>Open LumosDAO.io:</b> Navigate to the LumosDAO website.</li>
                                <li><b>Connect Wallet:</b> Click on the "Connect Wallet" button on the top right corner and
                                    choose from the available Stellar wallets. Hit "Connect Wallet."</li>
                                <li><b>Home Page:</b> After successfully connecting your wallet, you will land on the home
                                    page that displays platform stats and a list of existing DAOs.</li>
                                <li><b>Create a DAO:</b>
                                    <ul>
                                        <li>To set up a DAO for an existing Stellar token, enter the asset code and home
                                            domain. Make sure your connected wallet is authorized in the asset's toml file.
                                        </li>
                                        <li>If you're issuing a new token, connect a second wallet to serve as the issuing
                                            address. Fill in the necessary details and click "Create DAO."</li>
                                    </ul>
                                </li>
                                <li><b>Confirm Transaction:</b> Confirm the blockchain transaction to create the DAO.
                                    LumosDAO will also automatically generate and host the asset's toml file.</li>
                                <li><b>DAO Settings:</b> After creation, you can edit the asset's toml at any time.</li>
                            </ol>
                            <br>
                            <h3>For Proposal Creators</h3>
                            <ol>
                                <li><b>Join a DAO:</b> Navigate to the DAO you wish to join and click the "Join" button.
                                    Confirm the transaction to automatically set up a trustline from your wallet to the DAO.
                                </li>
                                <li><b>Access DAO Page:</b> Once you are a member, you can either create a new proposal or
                                    navigate through previous proposals.</li>
                                <li><b>Create Proposal:</b>
                                    <ul>
                                        <li>Click to create a new proposal.</li>
                                        <li>Fill in the title, description, and attach any necessary files.</li>
                                    </ul>
                                </li>
                                <li><b>Confirm Proposal:</b> Validate and confirm the proposal. Voting will open for 5 days.
                                </li>
                            </ol>
                            <br>
                            <h3>For Proposal Voters</h3>
                            <ol>
                                <li><b>Join a DAO:</b> If you are not already a member, join the DAO whose proposal you wish
                                    to vote on.</li>
                                <li><b>Access Proposal:</b> Navigate to the proposal you wish to vote on.</li>
                                <li><b>Cast Vote:</b> Choose between "YES" or "NO" and confirm your vote on the blockchain.
                                </li>
                                <li><b>Comment Section:</b> After casting your vote, you can participate in the proposal's
                                    comment section.</li>
                                <li><b>View Voting Power:</b> LumosDAO displays the voting power calculated for each vote.
                                </li>
                                <li><b>Final Results:</b> After the 5-day voting period, results are automatically
                                    calculated and posted on the proposal page.</li>
                            </ol>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
