@extends('layout')

@section('title', 'Classic - Contact Us')

@section('content')

<!-- =========================================================
     HERO SECTION
========================================================= -->

<section class="position-relative bg-dark text-white overflow-hidden py-5">

    <div class="position-absolute top-0 start-0 w-100 h-100">

        <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR7EbJ95yszhDtP7HMHfkSxmxbuIGERZmvC7ST2B9rulRSF1PW7bXZXMwQ&s=10"
            alt="Contact Hero Background"
            class="w-100 h-100 object-fit-cover opacity-50"
        >

    </div>

    <div class="container py-5 position-relative z-1 text-center">

        <span
            class="text-uppercase fw-bold small px-3 py-1 rounded-pill text-white mb-2 d-inline-block"
            style="background-color:#8cc63f; font-size:0.7rem;"
        >
            Get In Touch
        </span>

        <h1 class="fw-bold display-5 mb-2 text-white">
            We'd Love To Hear From You
        </h1>

        <p
            class="text-white-50 small mx-auto"
            style="max-width:500px;"
        >
            Have questions about our eyewear collections,
            prescriptions, or store locations?
            Drop us a message and our team will get back to you shortly.
        </p>

    </div>

</section>


<!-- =========================================================
     CONTACT INFORMATION
========================================================= -->

<section class="py-5 bg-white">

<div class="container">

<div class="row g-4 mb-5">

<!-- LOCATION -->

<div class="col-md-4">

<div class="card border-0 rounded-4 shadow-sm p-4 text-center h-100 bg-light">

<div class="mb-3">

<span
    class="rounded-circle d-inline-flex align-items-center justify-content-center text-white"
    style="width:50px;height:50px;background-color:#8cc63f;"
>
<i class="fa-solid fa-location-dot fs-5"></i>
</span>

</div>

<h5 class="fw-bold text-dark fs-6 mb-2">
Our Flagship Store
</h5>

<p class="text-muted small mb-0">
123 Fashion Avenue, Suite 400<br>
New York, NY 10001, USA
</p>

</div>

</div>


<!-- PHONE -->

<div class="col-md-4">

<div class="card border-0 rounded-4 shadow-sm p-4 text-center h-100 bg-light">

<div class="mb-3">

<span
    class="rounded-circle d-inline-flex align-items-center justify-content-center text-white"
    style="width:50px;height:50px;background-color:#8cc63f;"
>
<i class="fa-solid fa-phone fs-5"></i>
</span>

</div>

<h5 class="fw-bold text-dark fs-6 mb-2">
Phone Support
</h5>

<p class="text-muted small mb-0">
Mon - Fri: 8:00 AM - 8:00 PM<br>
+1 (800) 123-4567
</p>

</div>

</div>


<!-- EMAIL -->

<div class="col-md-4">

<div class="card border-0 rounded-4 shadow-sm p-4 text-center h-100 bg-light">

<div class="mb-3">

<span
    class="rounded-circle d-inline-flex align-items-center justify-content-center text-white"
    style="width:50px;height:50px;background-color:#8cc63f;"
>
<i class="fa-solid fa-envelope fs-5"></i>
</span>

</div>

<h5 class="fw-bold text-dark fs-6 mb-2">
Email Inquiry
</h5>

<p class="text-muted small mb-0">
Support: support@seemy.com<br>
Sales: sales@seemy.com
</p>

</div>

</div>

</div>


<!-- =========================================================
     ENQUIRY TABS
========================================================= -->

<div class="text-center mb-4">

<button
    type="button"
    id="newEnquiryBtn"
    onclick="showEnquirySection('new')"
    class="btn rounded-pill px-4 py-2 fw-bold me-2 shadow-sm"
    style="background-color:#8cc63f;color:white;"
>
    <i class="fa-solid fa-pen-to-square me-2"></i>
    Send New Enquiry
</button>


<button
    type="button"
    id="myEnquiryBtn"
    onclick="showEnquirySection('my')"
    class="btn btn-outline-dark rounded-pill px-4 py-2 fw-bold shadow-sm"
>
    <i class="fa-solid fa-comments me-2"></i>
    My Enquiries & Replies
</button>

</div>


<!-- =========================================================
     SUCCESS MESSAGE
========================================================= -->

@if(session('success'))

<div class="alert alert-success rounded-4 border-0 shadow-sm mb-4">

<i class="fa-solid fa-circle-check me-2"></i>

{{ session('success') }}

</div>

@endif


<!-- =========================================================
     VALIDATION ERRORS
========================================================= -->

@if($errors->any())

<div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4">

<ul class="mb-0">

@foreach($errors->all() as $error)

<li>{{ $error }}</li>

@endforeach

</ul>

</div>

@endif


<!-- =========================================================
     MAIN ROW
========================================================= -->

<div class="row g-5 align-items-stretch">


<!-- =====================================================
     LEFT SIDE
===================================================== -->

<div class="col-lg-7">


<!-- =====================================================
     SEND NEW ENQUIRY
===================================================== -->

<div id="newEnquirySection">

<div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">

<h3 class="fw-bold text-dark mb-2 fs-4">
Send Us A New Enquiry
</h3>

<p class="text-muted small mb-4">
Have a question about our products or services?
Send us your enquiry.
</p>


<form
    method="POST"
    action="{{ route('enquiry.store') }}"
>

@csrf

<div class="row g-3">


<!-- NAME -->

<div class="col-md-6">

<label class="form-label small fw-semibold">
Your Name
</label>

<input
    type="text"
    name="name"
    value="{{ old('name', auth()->user()->name ?? '') }}"
    class="form-control rounded-pill border-light bg-light py-2 px-3 shadow-none small"
    placeholder="Enter your name"
    required
>

</div>


<!-- EMAIL -->

<div class="col-md-6">

<label class="form-label small fw-semibold">
Your Email
</label>

<input
    type="email"
    name="email"
    value="{{ old('email', auth()->user()->email ?? '') }}"
    class="form-control rounded-pill border-light bg-light py-2 px-3 shadow-none small"
    placeholder="Enter your email"
    required
>

</div>


<!-- SUBJECT -->

<div class="col-12">

<label class="form-label small fw-semibold">
Subject
</label>

<input
    type="text"
    name="subject"
    value="{{ old('subject') }}"
    class="form-control rounded-pill border-light bg-light py-2 px-3 shadow-none small"
    placeholder="How can we help you?"
    required
>

</div>


<!-- MESSAGE -->

<div class="col-12">

<label class="form-label small fw-semibold">
Message
</label>

<textarea
    name="message"
    rows="5"
    class="form-control rounded-4 border-light bg-light p-3 shadow-none small"
    placeholder="Type your message here..."
    required
>{{ old('message') }}</textarea>

</div>


<!-- BUTTON -->

<div class="col-12 mt-4">

<button
    type="submit"
    class="btn text-white rounded-pill px-5 py-2 fw-bold small shadow-sm"
    style="background-color:#8cc63f;"
>

Send Enquiry

<i class="fa-solid fa-paper-plane ms-1"></i>

</button>

</div>

</div>

</form>

</div>

</div>


<!-- =====================================================
     MY ENQUIRIES
===================================================== -->

<div
    id="myEnquirySection"
    style="display:none;"
>

<div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">

<h3 class="fw-bold text-dark mb-2 fs-4">
My Enquiries & Replies
</h3>

<p class="text-muted small mb-4">
View your previous enquiries and replies from Classic.
</p>


@forelse($enquiries as $enquiry)

<div class="border rounded-4 p-4 mb-3 bg-light">


<!-- HEADER -->

<div class="d-flex justify-content-between align-items-start">

<div>

<h6 class="fw-bold mb-1">
{{ $enquiry->subject }}
</h6>

<small class="text-muted">
{{ $enquiry->created_at->format('d M Y, h:i A') }}
</small>

</div>


<!-- STATUS -->

@if($enquiry->status === 'pending')

<span class="badge bg-warning text-dark rounded-pill px-3 py-2">

<i class="fa-solid fa-clock me-1"></i>

Pending

</span>

@elseif($enquiry->status === 'replied')

<span class="badge bg-success rounded-pill px-3 py-2">

<i class="fa-solid fa-check me-1"></i>

Replied

</span>

@else

<span class="badge bg-secondary rounded-pill px-3 py-2">
Closed
</span>

@endif

</div>


<hr>


<!-- USER MESSAGE -->

<div class="mb-3">

<strong class="small">
Your Message
</strong>

<p class="text-muted small mb-0 mt-1">
{{ $enquiry->message }}
</p>

</div>


<!-- ADMIN REPLY -->

@if($enquiry->reply)

<div
    class="bg-white rounded-4 p-3 border-start border-4"
    style="border-color:#8cc63f !important;"
>

<strong class="small">

<i
    class="fa-solid fa-reply me-1"
    style="color:#8cc63f;"
></i>

Admin Reply

</strong>

<p class="text-muted small mb-0 mt-2">
{{ $enquiry->reply }}
</p>

</div>

@else

<div class="alert alert-warning rounded-4 small mb-0">

<i class="fa-solid fa-clock me-2"></i>

Your enquiry is pending.
Our team will reply soon.

</div>

@endif

</div>


@empty

<div class="text-center py-5">

<i class="fa-solid fa-envelope-open-text fs-1 text-muted mb-3"></i>

<h5 class="fw-bold">
No Enquiries Yet
</h5>

<p class="text-muted small">
You haven't submitted any enquiries yet.
</p>

<button
    type="button"
    onclick="showEnquirySection('new')"
    class="btn text-white rounded-pill px-4"
    style="background-color:#8cc63f;"
>
Send Your First Enquiry
</button>

</div>

@endforelse

</div>

</div>

</div>


<!-- =====================================================
     RIGHT SIDE STORE IMAGE
===================================================== -->

<div class="col-lg-5">

<div
    class="card border-0 rounded-4 overflow-hidden shadow-sm h-100 position-relative"
    style="min-height:400px;"
>

<img
    src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRj-mNbQ2mF4GTJG1OewLFeGycOXiyIWuMtDK98oy0mPw&s=10"
    alt="Store location"
    class="w-100 h-100 object-fit-cover position-absolute"
>

<div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50">
</div>

<div
    class="card-body position-relative z-1 d-flex flex-column justify-content-end p-4 text-white"
>

<span
    class="badge rounded-pill fw-bold px-3 py-2 mb-2 align-self-start"
    style="background-color:#8cc63f;"
>
VISIT US
</span>

<h4 class="fw-bold text-white mb-1 fs-5">
Experience Seemy In Person
</h4>

<p class="text-white-50 small mb-0">
Stop by our flagship branch to try out custom lens fittings
and check out our new seasonal drops.
</p>

</div>

</div>

</div>

</div>

</div>

</section>


<!-- =========================================================
     NEWSLETTER
========================================================= -->

<section
    class="py-4"
    style="background-color:#8cc63f;"
>

<div class="container text-center">

<h5 class="fw-bold text-white mb-2">
Let's Stay In Touch
</h5>

<p class="text-white small mb-3">
Get our latest news and exclusive updates right in your inbox.
</p>

<form
    onsubmit="event.preventDefault();"
    class="row justify-content-center g-2"
>

<div class="col-md-5">

<input
    type="email"
    placeholder="Enter your email address"
    class="form-control rounded-pill border-0 shadow-none px-4 py-2 small"
>

</div>

<div class="col-auto">

<button
    type="submit"
    class="btn btn-dark rounded-pill px-4 py-2 fw-bold small"
>

Subscribe

<i class="fa-solid fa-arrow-right ms-1"></i>

</button>

</div>

</form>

</div>

</section>



<!-- =========================================================
     USER REPLY NOTIFICATION
========================================================= -->

@if(auth()->check())

<!-- =========================================================
     NOTIFICATION POPUP
========================================================= -->

<div
    id="userReplyPopup"
    class="position-fixed"
    style="
        display:none;
        top:80px;
        right:25px;
        width:390px;
        max-width:92%;
        z-index:999999;
    "
>

<div class="card border-0 shadow-lg rounded-4 overflow-hidden">

<!-- HEADER -->

<div
    class="p-3 text-white d-flex justify-content-between align-items-start"
    style="background:#8cc63f;"
>

<div>

<div class="fw-bold">

<i class="fa-solid fa-bell me-2"></i>

New Reply

</div>

<small>
Admin replied to your enquiry
</small>

</div>


<button
    type="button"
    onclick="closeUserReplyPopup()"
    class="btn text-white p-0 border-0"
>

<i class="fa-solid fa-xmark fs-5"></i>

</button>

</div>


<!-- CONTENT -->

<div
    id="userReplyContent"
    class="p-4"
>
</div>


<!-- FOOTER -->

<div class="p-3 border-top text-center">

<button
    type="button"
    onclick="viewUserReply()"
    class="btn rounded-pill px-4 text-white fw-semibold"
    style="background:#8cc63f;"
>

<i class="fa-solid fa-comments me-1"></i>

View Reply

</button>

</div>

</div>

</div>


<!-- =========================================================
     NOTIFICATION SOUND
========================================================= -->

<audio
    id="userReplySound"
    preload="auto"
>

<source
    src="{{ asset('sounds/enquiry-notification.mp3') }}"
    type="audio/mpeg"
>

</audio>


<!-- =========================================================
     JAVASCRIPT
========================================================= -->

<script>

/*
|--------------------------------------------------------------------------
| GLOBAL VARIABLES
|--------------------------------------------------------------------------
*/

let userLastReplyId = 0;

let userNotificationStarted = false;

let userAudioUnlocked = false;

let userReplyPolling = null;


/*
|--------------------------------------------------------------------------
| STORAGE KEY
|--------------------------------------------------------------------------
*/

const USER_REPLY_STORAGE_KEY =
    'seemy_last_seen_reply_{{ auth()->id() }}';


/*
|--------------------------------------------------------------------------
| SHOW ENQUIRY SECTION
|--------------------------------------------------------------------------
*/

function showEnquirySection(section)
{

    const newSection =
        document.getElementById(
            'newEnquirySection'
        );

    const mySection =
        document.getElementById(
            'myEnquirySection'
        );

    const newBtn =
        document.getElementById(
            'newEnquiryBtn'
        );

    const myBtn =
        document.getElementById(
            'myEnquiryBtn'
        );


    if(section === 'new')
    {

        newSection.style.display =
            'block';

        mySection.style.display =
            'none';


        newBtn.style.backgroundColor =
            '#8cc63f';

        newBtn.style.color =
            'white';

        newBtn.style.borderColor =
            '#8cc63f';


        myBtn.style.backgroundColor =
            'white';

        myBtn.style.color =
            '#212529';

        myBtn.style.borderColor =
            '#212529';

    }

    else
    {

        newSection.style.display =
            'none';

        mySection.style.display =
            'block';


        myBtn.style.backgroundColor =
            '#8cc63f';

        myBtn.style.color =
            'white';

        myBtn.style.borderColor =
            '#8cc63f';


        newBtn.style.backgroundColor =
            'white';

        newBtn.style.color =
            '#212529';

        newBtn.style.borderColor =
            '#212529';

    }

}


/*
|--------------------------------------------------------------------------
| UNLOCK AUDIO
|--------------------------------------------------------------------------
|
| Browser autoplay restriction avoid करण्यासाठी
| user च्या पहिल्या click/touch वर audio unlock करतो.
|
|--------------------------------------------------------------------------
*/

function unlockUserNotificationSound()
{

    if(userAudioUnlocked)
    {
        return;
    }


    const sound =
        document.getElementById(
            'userReplySound'
        );


    if(!sound)
    {
        return;
    }


    sound.volume = 0;


    const playPromise =
        sound.play();


    if(playPromise !== undefined)
    {

        playPromise
            .then(function()
            {

                sound.pause();

                sound.currentTime = 0;

                sound.volume = 1;

                userAudioUnlocked = true;

                console.log(
                    'USER NOTIFICATION SOUND UNLOCKED'
                );

            })
            .catch(function(error)
            {

                console.log(
                    'Audio unlock waiting:',
                    error
                );

            });

    }

}


/*
|--------------------------------------------------------------------------
| USER CLICK / TOUCH
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'click',
    unlockUserNotificationSound,
    { once:false }
);

document.addEventListener(
    'touchstart',
    unlockUserNotificationSound,
    { once:false }
);


/*
|--------------------------------------------------------------------------
| GET SAVED REPLY ID
|--------------------------------------------------------------------------
*/

function getSavedReplyId()
{

    try
    {

        return Number(
            localStorage.getItem(
                USER_REPLY_STORAGE_KEY
            ) || 0
        );

    }
    catch(error)
    {

        console.log(
            'LocalStorage error:',
            error
        );

        return 0;

    }

}


/*
|--------------------------------------------------------------------------
| SAVE REPLY ID
|--------------------------------------------------------------------------
*/

function saveReplyId(id)
{

    try
    {

        localStorage.setItem(
            USER_REPLY_STORAGE_KEY,
            id
        );

    }
    catch(error)
    {

        console.log(
            'LocalStorage save error:',
            error
        );

    }

}


/*
|--------------------------------------------------------------------------
| CHECK USER REPLY
|--------------------------------------------------------------------------
*/

function checkUserReplyNotification()
{

    fetch(
        "{{ route('user.enquiry.notification') }}",
        {
            method:'GET',

            headers:
            {
                'Accept':
                    'application/json',

                'X-Requested-With':
                    'XMLHttpRequest'
            },

            credentials:
                'same-origin'
        }
    )

    .then(function(response)
    {

        if(!response.ok)
        {
            throw new Error(
                'HTTP Error: ' +
                response.status
            );
        }

        return response.json();

    })

    .then(function(data)
    {

        console.log(
            'USER REPLY NOTIFICATION:',
            data
        );


        if(!data || !data.success)
        {
            return;
        }


        /*
        |--------------------------------------------------------------------------
        | LATEST REPLY ID
        |--------------------------------------------------------------------------
        */

        let latestId = 0;


        if(data.latest && data.latest.id)
        {

            latestId =
                Number(
                    data.latest.id
                );

        }


        /*
        |--------------------------------------------------------------------------
        | FIRST PAGE LOAD
        |--------------------------------------------------------------------------
        |
        | First time page open केल्यावर जुना reply popup करू नये.
        |
        |--------------------------------------------------------------------------
        */

        if(!userNotificationStarted)
        {

            const savedId =
                getSavedReplyId();


            if(savedId > 0)
            {

                userLastReplyId =
                    savedId;

            }
            else if(latestId > 0)
            {

                /*
                | First visit.
                | Existing latest reply ला read समजतो.
                */

                userLastReplyId =
                    latestId;

                saveReplyId(
                    latestId
                );

            }


            userNotificationStarted =
                true;


            console.log(
                'Notification monitoring started.'
            );


            return;

        }


        /*
        |--------------------------------------------------------------------------
        | NEW REPLY DETECTED
        |--------------------------------------------------------------------------
        */

        if(
            latestId > 0 &&
            latestId > userLastReplyId
        )
        {

            console.log(
                'NEW USER REPLY FOUND:',
                latestId
            );


            /*
            | Save first so repeated polling
            | मध्ये duplicate notification येणार नाही.
            */

            userLastReplyId =
                latestId;

            saveReplyId(
                latestId
            );


            /*
            |--------------------------------------------------------------------------
            | SHOW POPUP
            |--------------------------------------------------------------------------
            */

            if(data.latest)
            {

                showUserReplyPopup(
                    data.latest
                );

            }


            /*
            |--------------------------------------------------------------------------
            | PLAY SOUND
            |--------------------------------------------------------------------------
            */

            playUserReplySound();

        }

    })

    .catch(function(error)
    {

        console.error(
            'User reply notification error:',
            error
        );

    });

}


/*
|--------------------------------------------------------------------------
| SHOW USER REPLY POPUP
|--------------------------------------------------------------------------
*/

function showUserReplyPopup(enquiry)
{

    const popup =
        document.getElementById(
            'userReplyPopup'
        );

    const content =
        document.getElementById(
            'userReplyContent'
        );


    if(!popup || !content)
    {
        return;
    }


    const subject =
        escapeUserNotification(
            enquiry.subject
        );


    const reply =
        escapeUserNotification(
            enquiry.reply
        );


    const repliedAt =
        escapeUserNotification(
            enquiry.replied_at || ''
        );


    content.innerHTML = `

        <div class="mb-3">

            <div class="small text-muted mb-1">

                <i class="fa-solid fa-envelope me-1"></i>

                Your Enquiry

            </div>

            <div class="fw-bold text-dark">

                ${subject}

            </div>

        </div>


        <div>

            <div class="small fw-bold text-dark mb-2">

                <i
                    class="fa-solid fa-reply me-1"
                    style="color:#8cc63f;"
                ></i>

                Admin Reply

            </div>


            <div
                class="bg-light rounded-4 p-3"
                style="line-height:1.6;"
            >

                ${reply}

            </div>

        </div>


        ${
            repliedAt
            ?
            `
            <div class="small text-muted mt-3">

                <i class="fa-regular fa-clock me-1"></i>

                ${repliedAt}

            </div>
            `
            :
            ''
        }

    `;


    popup.style.display =
        'block';


    /*
    |--------------------------------------------------------------------------
    | AUTO CLOSE
    |--------------------------------------------------------------------------
    */

    clearTimeout(
        window.userReplyPopupTimer
    );


    window.userReplyPopupTimer =
        setTimeout(
            function()
            {

                closeUserReplyPopup();

            },
            15000
        );

}


/*
|--------------------------------------------------------------------------
| CLOSE POPUP
|--------------------------------------------------------------------------
*/

function closeUserReplyPopup()
{

    const popup =
        document.getElementById(
            'userReplyPopup'
        );


    if(popup)
    {

        popup.style.display =
            'none';

    }


    clearTimeout(
        window.userReplyPopupTimer
    );

}


/*
|--------------------------------------------------------------------------
| VIEW REPLY
|--------------------------------------------------------------------------
*/

function viewUserReply()
{

    closeUserReplyPopup();


    showEnquirySection(
        'my'
    );


    const mySection =
        document.getElementById(
            'myEnquirySection'
        );


    if(mySection)
    {

        mySection.scrollIntoView(
            {
                behavior:'smooth',
                block:'start'
            }
        );

    }

}


/*
|--------------------------------------------------------------------------
| PLAY USER REPLY SOUND
|--------------------------------------------------------------------------
*/

function playUserReplySound()
{

    const sound =
        document.getElementById(
            'userReplySound'
        );


    if(!sound)
    {
        console.log(
            'Notification audio element not found.'
        );

        return;
    }


    sound.pause();

    sound.currentTime = 0;

    sound.volume = 1;


    const playPromise =
        sound.play();


    if(playPromise !== undefined)
    {

        playPromise
            .then(function()
            {

                console.log(
                    'USER REPLY SOUND PLAYING'
                );

                userAudioUnlocked = true;

            })
            .catch(function(error)
            {

                console.warn(
                    'Browser blocked notification sound.',
                    error
                );


                /*
                |--------------------------------------------------------------------------
                | If autoplay is blocked:
                | Popup still appears.
                |--------------------------------------------------------------------------
                */

            });

    }

}


/*
|--------------------------------------------------------------------------
| ESCAPE HTML
|--------------------------------------------------------------------------
*/

function escapeUserNotification(text)
{

    const div =
        document.createElement(
            'div'
        );


    div.textContent =
        text || '';


    return div.innerHTML;

}


/*
|--------------------------------------------------------------------------
| START NOTIFICATION SYSTEM
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'DOMContentLoaded',
    function()
    {

        console.log(
            'USER ENQUIRY NOTIFICATION SYSTEM STARTED'
        );


        /*
        |--------------------------------------------------------------------------
        | First check
        |--------------------------------------------------------------------------
        */

        checkUserReplyNotification();


        /*
        |--------------------------------------------------------------------------
        | Every 3 seconds
        |--------------------------------------------------------------------------
        */

        userReplyPolling =
            setInterval(
                function()
                {

                    checkUserReplyNotification();

                },
                3000
            );

    }
);

</script>

@endif

@endsection