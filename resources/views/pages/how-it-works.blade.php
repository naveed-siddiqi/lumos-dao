@extends('layouts.app')

@section('content')
<style>
      .ctn{
      padding: 40px;
    }
    .nav-link.collapsed {
      font-family: "MontSem";
      color: black;
    }
    .nav-link{
        display: flex;
        align-items: center;
        justify-content: left;
        gap: 20px;
        font-size: large;
    }
    .nav-sublink{
      font-size: medium;
      text-decoration: none;
      margin-left: 20px;
      color: gray;
    }
    .arrow::after {
      content: "\f107"; /* Unicode for right arrow */
      font-family: 'Font Awesome 5 Free';
      float: right;
      margin-left: auto;
      transition: transform 0.4s ease;
    }
    .arrow.collapsed::after {
      transform: rotate(90deg);
    }
    .sidebar-sticky{
        min-height: 80vh;
        padding: 50px 0px;
    }
    .sidebar{
        border-radius: 20px;
        border: 1px solid rgba(128, 128, 128, 0.154);
    }
    .nav-menu{
        gap: 15px;
    }
    .nav-item{
      border-bottom: 1px solid rgba(128, 128, 128, 0.086);
      padding-bottom:10px;
    }
    .nav-submenu{
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
    <div class="container">
    <div class="container-fluid ctn">
    <div class="row align-items-start justify-content-center">
      <nav class="col-md-3 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav nav-menu flex-column">
            <li class="nav-item">
              <a class="nav-link collapsed text-muted font-medium" data-toggle="collapse" href="#getting-started">
              <div class="flex-grow-1 d-flex align-items-center gap-3">
              <span>
              <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M8.885 15.058h1V8.942h-1zm3.23 0L16.712 12l-4.597-3.058zM12.003 21q-1.866 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.708-3.51t1.924-2.859t2.856-1.925T11.997 3t3.51.708t2.859 1.924t1.925 2.856t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709"/></svg>
              </span>  
              Getting started
              </div>
                <span class="arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                      </svg>                      
                </span>
                </a>
              <ul class="nav nav-submenu flex-column collapse text-secondary gap-3" id="getting-started">
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('DAO')">What is a DAO</a></li>
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('LumosDAO')">How is LumosDAO different</a></li>
              </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed text-muted" data-toggle="collapse" href="#how-its-works">
                <div class="flex-grow-1 d-flex align-items-center gap-3">
                    <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 256 256"><path fill="currentColor" d="M240 120a8 8 0 0 1-8 8h-32v32h8a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16h-32a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h8v-32H72v32h8a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16H48a16 16 0 0 1-16-16v-32a16 16 0 0 1 16-16h8v-32H24a8 8 0 0 1 0-16h96V88h-8a16 16 0 0 1-16-16V40a16 16 0 0 1 16-16h32a16 16 0 0 1 16 16v32a16 16 0 0 1-16 16h-8v24h96a8 8 0 0 1 8 8"/></svg>
                </span>  
                How its work
                </div>
               
                  <span class="arrow">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>                      
                  </span>
                  </a>
                  <ul class="nav nav-submenu flex-column collapse text-secondary gap-3" id="how-its-works">
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('DAO')">What is a DAO</a></li>
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('LumosDAO')">How is LumosDAO different</a></li>
              </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed text-muted" data-toggle="collapse" href="#DAOFeatures">
                <div class="flex-grow-1 d-flex align-items-center gap-3">
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 16 16"><path fill="currentColor" d="M13 4v8h-2V6H9v4H5v2H3V8h4V4z"/></svg>
                </span>  
                DAO Features
                </div>
                  <span class="arrow">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>                      
                  </span>
                  </a>
                  <ul class="nav nav-submenu flex-column collapse text-secondary gap-3" id="DAOFeatures">
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('DAO')">What is a DAO</a></li>
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('LumosDAO')">How is LumosDAO different</a></li>
              </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed text-muted" data-toggle="collapse" href="#UserFeatures">
                <div class="flex-grow-1 d-flex align-items-center gap-3">
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="M15 2H9v2H7v6h2V4h6zm0 8H9v2h6zm0-6h2v6h-2zM4 16h2v-2h12v2H6v4h12v-4h2v6H4z"/></svg>
                </span>  
                User Features
                </div>
                  <span class="arrow">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>                      
                  </span>
                  </a>
                  <ul class="nav nav-submenu flex-column collapse text-secondary gap-3" id="UserFeatures">
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('DAO')">What is a DAO</a></li>
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('LumosDAO')">How is LumosDAO different</a></li>
              </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link collapsed text-muted" data-toggle="collapse" href="#VotingPower">
                <div class="flex-grow-1 d-flex align-items-center gap-3">
                <span>
                <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" viewBox="0 0 24 24"><path fill="currentColor" d="m18 13l3 3v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4l3-3h.83l2 2H6.78L5 17h14l-1.77-2h-1.91l2-2zm1 7v-1H5v1zm-7.66-5l-4.95-4.93a.996.996 0 0 1 0-1.41l6.37-6.37a.975.975 0 0 1 1.4.01l4.95 4.95c.39.39.39 1.02 0 1.41L12.75 15a.962.962 0 0 1-1.41 0m2.12-10.59L8.5 9.36l3.55 3.54L17 7.95z"/></svg>
                </span>  
                Voting Power
                </div>
                  <span class="arrow">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="1rem" height="1rem">
                          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>                      
                  </span>
                  </a>
                  <ul class="nav nav-submenu flex-column collapse text-secondary gap-3" id="VotingPower">
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('DAO')">What is a DAO</a></li>
                <li class="nav-subitem"><a class="nav-sublink font-sm" href="#" onclick="showDemo('LumosDAO')">How is LumosDAO different</a></li>
              </ul>
              </li>
          </ul>
        </div>
      </nav>
      <main role="main" class="col-md-9 ml-sm-auto col-lg-9 px-md-4">
        <div id="demoText" class="mt-3">
          Click on a submenu to see the demo text here.
        </div>
      </main>
    </div>
  </div>

  <!-- Hamburger Menu for Mobile -->
  <div class="d-block d-md-none">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarCollapse" aria-controls="sidebarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </div>
    </div>
</section>
<script>
    function showDemo(text) {
      let demoText = '';
      if (text === 'DAO') {
        demoText = `
          <h5 class="font-medium">What is a DAO</h5>
          <p class="text-secondary font-normal">A DAO (Decentralized Autonomous Organization) is a self-governing organization run by smart contracts on a blockchain network. It operates without a central authority and relies on the consensus of its members.</p>
          <h5 class="font-medium">How is LumosDAO different</h5>
          <p class="text-secondary font-normal">LumosDAO is different because it offers a user-friendly platform for creating and managing DAOs on the Stellar blockchain. It provides tools for asset management, proposal voting, and more.</p>
        `;
      } else if (text === 'LumosDAO') {
        demoText = `
        <h5 class="font-medium">For DAO Creators</h5>
          <p class="text-secondary font-normal"><strong>Open LumosDAO.io:</strong> Navigate to the LumosDAO website.</p>
          <p class="text-secondary font-normal"><strong>Connect Wallet:</strong> Click on the "Connect Wallet" button on the top right corner and choose from the available Stellar wallets. Hit "Connect Wallet."</p>
          <p class="text-secondary font-normal"><strong>Home Page:</strong> After successfully connecting your wallet, you will land on the home page that displays platform stats and a list of existing DAOs.</p>
          <p class="text-secondary font-normal"><strong>Create a DAO:</strong> To set up a DAO for an existing Stellar token, enter the asset code and home domain. Make sure your connected wallet is authorized in the asset's toml file.</p>
          <p class="text-secondary font-normal">If you're issuing a new token, connect a second wallet to serve as the issuing address. Fill in the necessary details and click "Create DAO."</p>
          <p class="text-secondary font-normal"><strong>Confirm Transaction:</strong> Confirm the blockchain transaction to create the DAO. LumosDAO will also automatically generate and host the asset's toml file.</p>
          <p class="text-secondary font-normal"><strong>DAO Settings:</strong> After creation, you can edit the asset's toml at any time.</p>
        `;
      } // Add more conditions for other submenu items if needed

      document.getElementById('demoText').innerHTML = demoText;
    }

    document.querySelector('.navbar-toggler').addEventListener('click', function() {
      document.querySelector('.sidebar').classList.toggle('show');
    });
  </script>
@endsection