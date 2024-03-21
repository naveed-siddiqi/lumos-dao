@extends('layouts.app')

@section('content')
<style>
.panel-heading {
    width: auto;
    max-width: 100%;
    color: var(--black);
    align-self: center;
    margin-top: 0;
    margin-bottom: 16px;
    font-family: 'MontBold';
    font-size: 50px;
    font-weight: 800;
    line-height: 70px;
    position: static;
}

.font-semibold {
    font-family: 'MontSem';
}

.panel-paragraph {
    max-width: 1200px;
    text-align: left;
    align-self: center;
    margin-bottom: 8px;
    position: static;
    overflow: visible;
}

.btn {
    display: inline-block;
    font-family: 'MontSem';
    line-height: 1.5;
    color: white;
    text-align: center;
    text-decoration: none;
    vertical-align: middle;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    background: linear-gradient(to right, #FFA500, #FF4500, #FF0000);
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
}

*,
*::before,
*::after {
    -webkit-box-sizing: padding-box;
    box-sizing: padding-box;
}

.section-landing {
    margin-top: 150px;
}

.tickerwrapper {
    position: relative;
    top: 50px;
    left: 0%;
    background: #fff;
    width: 99.9%;
    height: 100px;
    overflow: hidden;
    cursor: pointer;
}

ul.list {
    position: relative;
    display: inline-block;
    list-style: none;
    padding: 0;
    margin: 0px 50px;
}

ul.list.cloned {
    position: absolute;
    top: 0px;
    left: 0px;
}

ul.list li {
    float: left;
    padding-left: 100px;
}

.lnd-slider-img {
    border-radius: 10px !important;
    box-shadow: 20px gray;
    border: 1px #cccccc solid;
}

.slider-container {
    max-width: 800px;
}

.description-container {
    position: absolute;
    bottom: 0;
    width: fit-content;
    right: 0%;
    margin-right: auto;
    max-width: 500px;
    margin-top: 0px;
}
.logo-lumos-font{
    color: black;
    margin-top: 20px;
    font-family: 'MontBold';
}
.slick-prev,
.slick-next {
    background-color: gray;
    border-radius: 50%;
    top:102%;
}
.slick-prev:hover {
    background-color: red !important;
}
.slick-next:hover {
    background-color: red !important;
}
.paragraph-slider {
    font-family: 'MontReg';
}

.heading-slider {
    font-family: 'MontBold';
}

.why-choose {
    display: flex;
    margin: 50px 0px;
}

.heading-2.ranking {
    width: auto;
    text-align: left;
    font-size: 30px;
    line-height: 35px;
    font-family: 'MontSem';
}

.why-choose li {
    font-family: 'MontReg';
    margin-top: 10px;
    flex-direction: column;
}

strong {
    font-family: 'MontSem';
}

.content-panel-getintouch.background-gradient-dark {
    min-height: auto;
    background: #f3f4f6;
    justify-content: center;
    align-items: center;
    padding-top: 160px;
    padding-bottom: 160px;
    display: flex;
}

.content-panel-getintouch {
    width: 100%;
    height: auto;
    min-height: 100svh;
    color: #2e2a33;
    background-color: #fff;
    margin-top: auto;
    padding: 80px 48px;
    font-family: Mulish, sans-serif;
    font-size: 18px;
    line-height: 28px;
    display: block;
    overflow: hidden;
}

.panel-text {
    max-width: 940px;
    flex-direction: column;
    justify-content: center;
    align-items: flex-start;
    padding-bottom: 0;
    display: flex;
}

.panel-paragraph.git {
    text-align: center;
}

.panel-paragraph {
    max-width: 1200px;
    text-align: left;
    align-self: center;
    margin-bottom: 8px;
    position: static;
    overflow: visible;
}

.video-lnd {
    width: 600px;
    height: 100%;
    max-width: 600px;
    height: 450px;
}

@media (max-width: 900px){
    .description-container {
        position: static;
        margin-top: 20px;
    }
};

@media (max-width:600px) {
    .why-choose {
        flex-direction: column;
    }

    .video-lnd {
        width: 100%;
        height: 100%;
        max-width: 600px;
        height: 250px;
    }

    .panel-heading {
        font-size: 40px;
        line-height: 50px;
    }

    .section-landing {
        margin-top: 20px;
    }

    .panel-paragraph.git {
        text-align: start;
    }

    .panel-heading {
        align-self: start;
    }

    .content-panel-getintouch.background-gradient-dark {
        padding-top: 20px;
        padding-bottom: 20px;
    }
}
</style>
<main>
    <div class="container section-landing">
        <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center gap-5">
            <div class="">
                <h2 class="panel-heading">Empower Your Governance with LumosDAO</h2>
                <p class="panel-paragraph">LumosDAO revolutionizes decentralized governance on Soroban, enabling
                    transparent
                    voting and proposal creation for communities to grow and collaborate seamlessly.</p>
                <button class="btn">Learn more</button>
            </div>
            <div class="html-embed w-embed w-iframe">
                <video class="video-lnd" controls>
                    <source src="{{ asset('images/raza_rizvi91-v2.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>
    </div>
    <div class="">
        <h2 class="font-semibold">Trusted By:</h2>
        <div class="tickerwrapper">
            <ul class='list'>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                        alt="Transistor" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                        alt="SavvyCal" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                        alt="Statamic" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                        alt="Transistor" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                        alt="SavvyCal" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                        alt="Statamic" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/transistor-logo-gray-900.svg"
                        alt="Transistor" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/reform-logo-gray-900.svg" alt="Reform"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/tuple-logo-gray-900.svg" alt="Tuple"
                        width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/savvycal-logo-gray-900.svg"
                        alt="SavvyCal" width="158" height="48">
                </li>
                <li class='listitem'>
                    <img class=" " src="https://tailwindui.com/img/logos/158x48/statamic-logo-gray-900.svg"
                        alt="Statamic" width="158" height="48">
                </li>
            </ul>
        </div>
    </div>

    <div class="container section-landing">
    <div style="margin-top:50px;" class="container section-landing w-75">
        <div class="text-sm-center">
            <h2 class="panel-heading">Core Features of LumosDAO</h2>
            <p class="panel-paragraph text-sm-center w-100 w-sm-75 mx-auto">Unlock the full potential of decentralized
                governance
                with LumosDAO's suite of features designed for efficiency, transparency, and community empowerment.
                Explore our core functionalities that set the foundation for democratic decision-making.</p>
        </div>
    </div>
        <div style="margin-top:80px;" class="row position-relative">
            <div class="slider-container">
                <div class="slider">
                    <div><img class="lnd-slider-img w-100" src="{{ asset('images/point 1.png') }}" alt="Slide 1"></div>
                    <div><img class="lnd-slider-img w-100" src="{{ asset('images/point 2.png') }}" alt="Slide 2"></div>
                    <div><img class="lnd-slider-img w-100" src="{{ asset('images/point 3.png') }}" alt="Slide 3"></div>
                    <div><img class="lnd-slider-img w-100" src="{{ asset('images/point 1.png') }}" alt="Slide 4"></div>
                </div>
            </div>
            <div class="description-container">
                <h3 id="heading" class="heading-slider"></h3>
                <p id="paragraph" class=" paragraph-slider"></p>
            </div>
        </div>
    </div>
    <section class="container">
        <div class="container section-landing w-75">
            <div class="text-sm-center">
                <h2 class="panel-heading">Why Choose LumosDAO</h2>
                <p class="panel-paragraph text-sm-center w-100 w-sm-75 mx-auto">LumosDAO offers a range of benefits
                    tailored to meet
                    the needs of both DAO members and creators, ensuring a robust, transparent, and user-friendly
                    platform for decentralized governance.</p>
            </div>
        </div>
        <div style="margin-top:80px;" class="why-choose">
            <ul>
                <h3 class="heading-2 ranking" aria-hidden="true">
                    For DAO Creators:
                </h3>
                <li>
                    <strong> Easy Setup:</strong><br>
                    Simplified DAO creation tools enable quick launch of decentralized organizations with customizable
                    governance models.
                </li>
                <li>
                    <strong>Financial Oversight:</strong><br>
                    Integrated budget/treasury management features provide clear oversight of financial operations and
                    fund
                    allocation.

                </li>
                <li>
                    <strong>Scalable Governance:</strong><br>
                    The platform supports scalable governance structures, accommodating growing communities and evolving
                    governance needs.

                </li>

                <li>
                    <strong> Operational Efficiency:</strong><br>
                    Automated processes for proposals, voting, and member management reduce administrative overhead.
                </li>

                <li>
                    <strong>Community Building: </strong><br>
                    Tools for engagement and communication help in nurturing an active and involved DAO community.
                </li>
                <li>
                    <strong>Token Issuance: </strong><br>
                    Generate new tokens directly on LumosDAO and seamlessly set up their corresponding DAO.
                </li>
            </ul>
            <ul>
                <h3 class="heading-2 ranking" aria-hidden="true">
                    For DAO Members:
                </h3>
                <li>
                    <strong>Enhanced Participation: </strong><br>
                    With voting power delegation, members can contribute to decision-making processes, even with limited
                    time or
                    expertise.
                </li>
                <li>
                    <strong>Community Engagement: </strong><br>
                    Direct involvement in governance fosters a stronger sense of community and shared purpose.
                </li>
                <li>
                    <strong>Greater Transparency:</strong><br>
                    Direct involvement in governance fosters a stronger sense of community and shared purpose.
                </li>
                <li>
                    <strong>Security and Trust:</strong><br>
                    Advanced security protocols protect members' interests and ensure the integrity of voting and
                    transactions.
                </li>

                <li>
                    <strong> Accessibility:</strong><br>
                    A user-friendly interface makes participation in DAO activities straightforward for members of all
                    technical
                    levels.
                </li>
            </ul>
        </div>
    </section>
    <section class="content-panel-getintouch background-gradient-dark">
        <div class="">
            <div class="panel-text git">
                <h2 class="panel-heading">Get in touch</h2>
                <p class="panel-paragraph git">
                    We're here to help and answer any questions you might have about LumosDAO. Whether you're curious
                    about
                    decentralized governance, need assistance with the platform, or want to join our growing community,
                    our team
                    is ready to connect with you.
                </p>
                <p class="panel-paragraph git">
                    <strong>Email Us:</strong>
                    For detailed inquiries or support, drop us an email at info@lumosdao.io we'll get back to you as
                    soon as
                    possible.
                </p>
                <p class="panel-paragraph git">
                    <strong>Reach Out on X.com:</strong>
                    For quick questions or to follow our updates, message us directly at <strong>@DAOLumos</strong>.
                    Let's start a
                    conversation!
                </p>
                <p class="panel-paragraph git">
                    We look forward to hearing from you and welcoming you to the LumosDAO community.
                </p>
                <div class="d-flex align-items-center justify-content-center w-100">
                    <a href="#" class="btn btnreg">Book a
                        demo</a>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('scripts')
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Slick slider
    $('.slider').slick({
        fade: true,
        dots: true,
        infinite: true,
        speed: 500,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
    });

    // Define descriptions
    var descriptions = [{
            heading: "Seamless DAO Creation",
            paragraph: "Instantly establish your DAO with customizable governance structures to suit your community’s unique needs."
        },
        {
            heading: "Transparent Proposal & Voting",
            paragraph: "Facilitate democratic decisions with our transparent proposal submission and voting mechanism, ensuring every voice is heard."
        },
        {
            heading: "Flexible Voting Power Delegation",
            paragraph: "Empower members to delegate their voting rights, enhancing participation and inclusivity within your DAO."
        },
        {
            heading: "Efficient Budget Management",
            paragraph: "Manage your DAO’s finances with clarity. Propose, vote, and allocate funds transparently within the platform."
        }
    ];

    // Update descriptions on slider change
    $('.slider').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
        $('#heading').text(descriptions[nextSlide].heading);
        $('#paragraph').text(descriptions[nextSlide].paragraph);
    });

    // Trigger 'beforeChange' event manually to display description on page load
    var currentSlide = $('.slider').slick('slickCurrentSlide');
    $('#heading').text(descriptions[currentSlide].heading);
    $('#paragraph').text(descriptions[currentSlide].paragraph);
});


var $tickerWrapper = $(".tickerwrapper");
var $list = $tickerWrapper.find("ul.list");
var $clonedList = $list.clone();
var listWidth = 10;

$list.find("li").each(function(i) {
    listWidth += $(this, i).outerWidth(true);
});

var endPos = $tickerWrapper.width() - listWidth;

$list.add($clonedList).css({
    "width": listWidth + "px"
});

$clonedList.addClass("cloned").appendTo($tickerWrapper);
var infinite = new TimelineMax({
    repeat: -1,
    paused: true
});
var time = 40;

infinite
    .fromTo($list, time, {
        rotation: 0.01,
        x: 0
    }, {
        force3D: true,
        x: -listWidth,
        ease: Linear.easeNone
    }, 0)
    .fromTo($clonedList, time, {
        rotation: 0.01,
        x: listWidth
    }, {
        force3D: true,
        x: 0,
        ease: Linear.easeNone
    }, 0)
    .set($list, {
        force3D: true,
        rotation: 0.01,
        x: listWidth
    })
    .to($clonedList, time, {
        force3D: true,
        rotation: 0.01,
        x: -listWidth,
        ease: Linear.easeNone
    }, time)
    .to($list, time, {
        force3D: true,
        rotation: 0.01,
        x: 0,
        ease: Linear.easeNone
    }, time)
    .progress(1).progress(0)
    .play();
$tickerWrapper.on("mouseenter", function() {
    infinite.pause();
}).on("mouseleave", function() {
    infinite.play();
});
</script>
@endpush