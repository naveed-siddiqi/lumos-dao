@extends('layouts.app')
@section('content')
<style>
.ctn {
    padding: 40px;
}
p{
    color: #5e5a5a;
}
.transition-all {
    transition: all 0.5s;
}

.menu-open {
    display: block !important;
    transition: all 0.5s;
}

.tab-content {
    display: none;
}

.ctn {
    padding: 40px;
}

.nav-link.collapsed {
    font-family: "MontSem";
    color: black;
}

.nav-link {
    display: flex;
    align-items: center;
    justify-content: left;
    gap: 20px;
    font-size: large;
}

.nav-sublink {
    font-size: medium;
    text-decoration: none;
    margin-left: 20px;
    color: gray;
}


.arrow.collapsed::after {
    transform: rotate(90deg);
}

.sidebar-sticky {
    min-height: 80vh;
    padding: 50px 0px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.sidebar {
    border-radius: 20px;
    border: 1px solid rgba(128, 128, 128, 0.154);
    max-width: 25%;
    padding: 0px 20px;
}

.nav-menu {
    gap: 15px;
}

.nav-item {
    border-bottom: 1px solid rgba(128, 128, 128, 0.086);
    padding-bottom: 10px;
}

.nav-submenu {
    margin-left: 20px;
}

@media (max-width: 767px) {
    .sidebar {
        position: fixed;
        z-index: 1;
        top: 0;
        left: -250px;
        width: 250px;
        height: 100%;
        overflow-x: hidden;
        transition: 0.5s;
    }

    .sidebar.show {
        left: 0;
    }

    .sidebar-sticky {
        position: relative;
        top: 0;
        height: 100%;
        overflow-y: auto;
    }

    .nav-item {
        padding: 8px;
    }
}
</style>
<section>
    <div class="container d-flex align-items-center ctn">
        <div class="row align-items-start justify-content-center w-100">
            <div class="col-md-3 d-none d-md-block bg-light sidebar w-100">
                <div class="sidebar-sticky w-100">
                    <div class="">
                        <button
                            class="border-0 bg-transparent font-sm mb-2 Explorer_p text-muted w-100 d-flex align-items-center"
                            onclick="openTab(event, 'getStarted')">
                            <div class="flex-grow-1 d-flex align-items-center gap-2 font-medium">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em"
                                        viewBox="0 0 24 24">
                                        <path fill="currentColor"
                                            d="M8.885 15.058h1V8.942h-1zm3.23 0L16.712 12l-4.597-3.058zM12.003 21q-1.866 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.708-3.51t1.924-2.859t2.856-1.925T11.997 3t3.51.708t2.859 1.924t1.925 2.856t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709" />
                                    </svg>
                                </span>
                                Getting started
                            </div>
                            <!-- <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span> -->
                        </button>
                        <!-- <div id="menu1" class="transition-all w-100" style="display: none; margin-left:30px;">
                            <div class="d-flex flex-column align-items-start gap-2">
                                <a class="text-muted border-0 text-decoration-none" href="#getStarted"
                                    onclick="openTab(event, 'getStarted')">Tab 1</a>
                                <a class="text-muted border-none text-decoration-none" href="#getStartedfix"
                                    onclick="openTab(event, 'getStartedfix')">Tab 2</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="">
                        <button
                            class="border-0 bg-transparent font-sm mb-2 Explorer_p text-muted w-100 d-flex align-items-center"
                            onclick="toggleMenu('menu2')">
                            <div class="flex-grow-1 d-flex align-items-center gap-2 font-medium">
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 256 256"><path fill="currentColor" d="M240 120a8 8 0 0 1-8 8h-32v32h8a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16h-32a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h8v-32H72v32h8a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16H48a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h8v-32H24a8 8 0 0 1 0-16h96V88h-8a16 16 0 0 1-16-16V40a16 16 0 0 1 16-16h32a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16h-8v24h96a8 8 0 0 1 8 8"/></svg>
                                </span>
                                How it works
                            </div>
                            <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div id="menu2" class="transition-all w-100" style="display: none; margin-left:30px;">
                            <div class="d-flex flex-column align-items-start gap-2">
                                <a class="text-muted border-0 text-decoration-none" href="#CreatingDAO"
                                    onclick="openTab(event, 'CreatingDAO')">Creating a DAO</a>
                                <a class="text-muted border-none text-decoration-none" href="#CreatingProposal"
                                    onclick="openTab(event, 'CreatingProposal')">Creating Proposals</a>
                                <a class="text-muted border-none text-decoration-none" href="#Voting"
                                    onclick="openTab(event, 'Voting')">Voting</a>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button
                            class="border-0 bg-transparent font-sm mb-2 Explorer_p text-muted w-100 d-flex align-items-center"
                            onclick="openTab(event, 'DAOFeature')">
                            <div class="flex-grow-1 d-flex align-items-center gap-2 font-medium">
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16"><path fill="currentColor" d="M13 4v8h-2V6H9v4H5v2H3V8h4V4z"/></svg>
                                </span>
                                DAO features
                            </div>
                            <!-- <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span> -->
                        </button>
                        <!-- <div id="menu3" class="transition-all w-100" style="display: none; margin-left:30px;">
                            <div class="d-flex flex-column align-items-start gap-2">
                                <a class="text-muted border-0 text-decoration-none" href="#getStarted"
                                    onclick="openTab(event, 'DAOFeature')">Tab 3</a>
                                <a class="text-muted border-none text-decoration-none" href="#getStartedfix"
                                    onclick="openTab(event, 'getStartedfix')">Tab 4</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="">
                        <button
                            class="border-0 bg-transparent font-sm mb-2 Explorer_p text-muted w-100 d-flex align-items-center"
                            onclick="openTab(event, 'UserExplorer')">
                            <div class="flex-grow-1 d-flex align-items-center gap-2 font-medium">
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M15 2H9v2H7v6h2V4h6zm0 8H9v2h6zm0-6h2v6h-2zM4 16h2v-2h12v2H6v4h12v-4h2v6H4z"/></svg>
                                </span>
                                User features
                            </div>
                            <!-- <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span> -->
                        </button>
                        <!-- <div id="menu4" class="transition-all w-100" style="display: none; margin-left:30px;">
                            <div class="d-flex flex-column align-items-start gap-2">
                                <a class="text-muted border-0 text-decoration-none" href="#getStarted"
                                    onclick="openTab(event, 'UserExplorer')">Tab 3</a>
                                <a class="text-muted border-none text-decoration-none" href="#getStartedfix"
                                    onclick="openTab(event, 'getStartedfix')">Tab 4</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="">
                        <button
                            class="border-0 bg-transparent font-sm mb-2 Explorer_p text-muted w-100 d-flex align-items-center"
                            onclick="openTab(event, 'VotingPower')">
                            <div class="flex-grow-1 d-flex align-items-center gap-2 font-medium">
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m18 13l3 3v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4l3-3h.83l2 2H6.78L5 17h14l-1.77-2h-1.91l2-2zm1 7v-1H5v1zm-7.66-5l-4.95-4.93a.996.996 0 0 1 0-1.41l6.37-6.37a.975.975 0 0 1 1.4.01l4.95 4.95c.39.39.39 1.02 0 1.41L12.75 15a.962.962 0 0 1-1.41 0m2.12-10.59L8.5 9.36l3.55 3.54L17 7.95z"/></svg>
                                </span>
                                Voting power
                            </div>
                            <!-- <span class="arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span> -->
                        </button>
                        <!-- <div id="menu4" class="transition-all w-100" style="display: none; margin-left:30px;">
                            <div class="d-flex flex-column align-items-start gap-2">
                                <a class="text-muted border-0 text-decoration-none" href="#VotingPower"
                                    onclick="openTab(event, 'getStarted')">Tab 3</a>
                                <a class="text-muted border-none text-decoration-none" href="#getStartedfix"
                                    onclick="openTab(event, 'getStartedfix')">Tab 4</a>
                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="col-md-9 ml-sm-auto col-lg-9 px-md-5 mt-3">
                <div style="display: block;" class="tab-content show" id="getStarted">
                    <h4 class="font-medium">Getting started:</h4>
                    <p class="">Connecting wallet: To begin using LumosDAO, please connect your Freighter wallet. If you
                        have not yet installed the <a href="">Freighter wallet extension</a>, it is available for
                        download from the Chrome Web Store. After installation, create your new Stellar wallet and link
                        Freighter with LumosDAO.</p>
                </div>
                <div class="tab-content" id="CreatingDAO">
                    <h4 class="font-medium">Creating a DAO:</h4>
                    <p class="">On the homepage, select “Create DAO”. There are two methods to establish a DAO for your
                        project:</p>
                    <ol class="mt-5">
                        <li>
                            <h5 class="font-medium">For an Existing Project:</h5>
                            <p>If your project already has a token on the Stellar blockchain, you will need to import it
                                into LumosDAO. Begin by entering the asset code and the TOML URL of your asset, then
                                click "Search". LumosDAO will retrieve all relevant data for the asset, such as logo,
                                description, and home domain, from the TOML file.</p>
                            <br>
                            <p>Next, wrap your assets to convert Stellar-based assets to Soroban format. LumosDAO
                                provides a one-click solution for this process, enabling you to complete the setup
                                swiftly. Finally, click "Create DAO'' and confirm the transaction in your wallet.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">For an Existing Project:</h5>
                            <p>If your project already has a token on the Stellar blockchain, you will need to import it
                                into LumosDAO. Begin by entering the asset code and the TOML URL of your asset, then
                                click "Search". LumosDAO will retrieve all relevant data for the asset, such as logo,
                                description, and home domain, from the TOML file.</p>
                        </li>
                    </ol>
                </div>
                <div class="tab-content" id="CreatingProposal">
                    <h4 class="font-medium">Creating Proposals:</h4>
                    <p class="">To create a proposal, you must first be a member of the DAO. Click "Join DAO" and
                        confirm the transaction to become a member. After joining, navigate to the DAO page and select
                        "Create Proposal". Enter the title and description of your proposal and attach any relevant
                        documents (optional). Once approved, the voting on proposals will be open for 5 days. Please
                        note that all proposals are subject to moderation by the DAO administrators.</p>
                </div>
                <div class="tab-content" id="Voting">
                    <h4 class="font-medium">Voting:</h4>
                    <p class="">After a proposal is approved, DAO members may cast their votes. When voting, members
                        have the option to provide a reason for their vote. This reason will be publicly displayed on
                        the proposal page under the voters section.</p>
                </div>
                <div class="tab-content" id="DAOFeature">
                    <h4 class="font-medium">DAO features:</h4>
                    <ol class="mt-5">
                        <li>
                            <h5 class="font-medium">TOML Generation and Hosting:</h5>
                            <p>LumosDAO automatically generates and hosts the asset’s TOML file. DAO creators can update
                                the TOML details by navigating through the DAO settings.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Automatic Asset Wrapping::</h5>
                            <p>This feature automatically converts Classic Stellar assets to Soroban, facilitating the
                                setup of the DAO on LumosDAO.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Bulletin:</h5>
                            <p>DAO administrators can use this space to post project-related news and announcements.
                                Additionally, they can conduct polls for community engagement.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Voting Power Delegation:</h5>
                            <p>Users can delegate their voting power to another wallet within the same DAO, allowing
                                another individual to make decisions on their behalf. This delegation can be revoked at
                                any time by the delegator.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">File Attachments:</h5>
                            <p>Proposal creators can attach relevant files to their proposals, including images, PDFs,
                                or text files.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Proposal Moderation:</h5>
                            <p>To prevent spam, all proposals are manually moderated by the DAO creators or
                                administrators.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Admin and Roles:</h5>
                            <p>The DAO creator can appoint multiple administrators and assign them specific roles,
                                enhancing community management efficiency.</p>
                        </li>
                    </ol>
                </div>
                <div class="tab-content" id="UserExplorer">
                    <h4 class="font-medium">DAO features:</h4>
                    <ol class="mt-5">
                        <li>
                            <h5 class="font-medium">User Explorer:</h5>
                            <p>This feature maintains a record of all user activities, which are publicly visible on the
                                user’s profile for enhanced transparency.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Messaging:</h5>
                            <p>Users can send private messages to different wallets, facilitating direct communication.
                            </p>
                        </li>
                        <li>
                            <h5 class="font-medium">Linking Social Profiles:</h5>
                            <p>Users can link their social media profiles with LumosDAO, integrating their social
                                presence with their DAO activities.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Commenting:</h5>
                            <p>After casting a vote on a proposal, users can add comments to provide further insights or
                                opinions.</p>
                        </li>
                    </ol>
                </div>
                <div class="tab-content" id="VotingPower">
                    <h4 class="font-medium">Voting power:</h4>
                    <p>How is voting power calculated?</p>
                    <ol class="my-3">
                        <p>In LumosDAO, voting power is determined by combining scores from three categories: Token
                            Holdings, DAO Activity, and Wallet Metrics. Here’s a brief breakdown:</p>
                        <li>
                            <h5 class="font-medium">Token Holdings:</h5>
                            <p>This score is based on the user's rank among token holders in the DAO,
                                ranging from 1 to 5. Higher rankings (e.g., being one of the top 5 holders) receive
                                higher scores.</p>
                        </li>
                        <li>
                        <h5 class="font-medium">DAO Activity:</h5>
                            <p>DAO Activity: This includes the number of proposals a user has voted on and the number of
                                comments they've made on proposals, with more activity leading to higher scores.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Wallet Metrics: </h5>
                            <p>This score considers the age of the user’s account, their account
                                balance, and the number of trades they have completed. More seasoned accounts with
                                higher balances and more trades score higher.</p>
                        </li>
                        <li>
                            <h5 class="font-medium">Commenting:</h5>
                            <p>After casting a vote on a proposal, users can add comments to provide further insights or
                                opinions.</p>
                        </li>
                    </ol>
                    <p>The formula to calculate the voting power (VP) is a weighted sum:</p>
                    <h5 class="font-medium">
                        VP=(0.5×Token Holdings Score)+(0.25×DAO Activity Sub-score)+(0.25×Wallet Metrics Sub-score)
                    </h5>
                    <p class="mt-3">Each category’s contribution to the voting power is weighted differently, with Token Holdings
                        having the highest impact (50%).</p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
function toggleMenu(menuId) {
    let menu = document.getElementById(menuId);
    menu.classList.toggle("menu-open");
}

function openTab(event, tabId) {
    event.preventDefault();
    $('.tab-content').hide(); // Hide all tabs
    $('#' + tabId).show(); // Show the selected tab
}
</script>
@endsection