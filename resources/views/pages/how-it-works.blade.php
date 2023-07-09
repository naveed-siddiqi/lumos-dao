@extends('layouts.app')

@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div>
                        <h1 class="text-center">How It Works</h1>

                        <p>&nbsp;</p>

                        <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt"><strong>For DAO
                                        Creators:</strong></span></span></p>

                        <ol>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Log in to
                                        LumosDAO using your Stellar wallet, such as Freighter, Rabet, or
                                        Xbull.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Click on the
                                        &quot;Create DAO&quot; button and enter the asset code and homedomain of the project
                                        you want to create a DAO for.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">LumosDAO
                                        will automatically fetch essential project data, like the logo, team wallets, and
                                        description, from the TOML file.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Select the
                                        wallets that you want to make visible to members and add a name to these wallets.
                                        This ensures transparency and trust within the DAO community.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Select the
                                        minimum amount of tokens the Proposal creator must hold.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">To
                                        complete the DAO creation process, pay a one-time fee of 10,000 LUMOS tokens, the
                                        native token of LumosDAO.</span></span></li>
                        </ol>

                        <p>&nbsp;</p>

                        <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt"><strong>For
                                        Proposal Creators:</strong></span></span></p>

                        <ol>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Join a DAO
                                        on LumosDAO by confirming the transaction on the Stellar network and owning the
                                        required number of tokens specified by the DAO creator.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">As a
                                        member of the DAO, create a proposal by providing a detailed description and setting
                                        a budget for the proposal.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">After
                                        creating the proposal, it enters a 5-day voting period, during which all DAO members
                                        can cast their votes.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Actively
                                        participate in the voting process by reviewing the proposal details.</span></span>
                            </li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">All votes
                                        are signed on the blockchain, ensuring transparency, integrity, and an accurate
                                        representation of the DAO members&#39; decisions.</span></span></li>
                        </ol>

                        <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt"><strong>For
                                        Voters:</strong></span></span></p>

                        <ol>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Join a DAO
                                        on LumosDAO by confirming the transaction on the Stellar network and owning the
                                        required number of tokens set by the DAO creator.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">As a
                                        voter, you have the opportunity to participate in the decision-making process by
                                        casting your vote on proposals.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Carefully
                                        review the proposal details and make an informed decision before voting in favor or
                                        against the proposal.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">All votes
                                        are securely recorded on the Stellar blockchain, providing transparency and ensuring
                                        the legitimacy of the voting process.</span></span></li>
                            <li><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">Through
                                        your participation, you contribute to the democratic governance of the DAO and help
                                        shape the future of decentralized projects on the Stellar blockchain.</span></span>
                            </li>
                        </ol>

                        <p><span style="font-family:Arial,Helvetica,sans-serif"><span style="font-size:11pt">LumosDAO
                                    empowers you as a DAO creator, proposal creator, or voter, enabling you to actively
                                    participate in decentralized governance and collaborate with others to drive the success
                                    of Stellar-based projects.</span></span></p>

                        <p>&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
