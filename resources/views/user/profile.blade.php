@extends('user/master')
@section('content')
    <!--===============================================================================================-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/luxonauta/luxa@8a98/dist/compressed/luxa.css">

    <style>
    main section {
        width: 100%;
    }
    main section .lx-column.column-user-pic {
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
    }
    main section .profile-pic {
        width: auto;
        max-width: 20rem;
        margin: 3rem 2rem;
        padding: 2rem;
        display: flex;
        flex-flow: wrap column;
        align-items: center;
        justify-content: center;
        border-radius: 0.25rem;
        background-color: white;
        position: relative;
    }
    main section .profile-pic .pic-label {
        width: 100%;
        margin: 0 0 1rem 0;
        text-align: center;
        font-size: 1.4rem;
        font-weight: 700;
    }
    main section .profile-pic .pic {
        width: 16rem;
        height: 16rem;
        position: relative;
        overflow: hidden;
        border-radius: 50%;
    }
    main section .profile-pic .pic .lx-btn {
        opacity: 0;
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        position: absolute;
        transform: translate(-50%, -50%);
        top: 50%;
        left: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        text-transform: none;
        font-size: 1rem;
        color: white;
        background-color: rgba(0, 0, 0, 0.8);
    }
    main section .profile-pic .pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
    }
    main section .profile-pic .pic:focus .lx-btn, main section .profile-pic .pic:focus-within .lx-btn, main section .profile-pic .pic:hover .lx-btn {
        opacity: 1;
        display: flex;
    }
    main section .profile-pic .pic-info {
        width: 100%;
        margin: 2rem 0 0 0;
        font-size: 0.9rem;
        text-align: center;
    }
    main section form {
        width: auto;
        min-width: 15rem;
        max-width: 25rem;
        margin: 3rem 0 0 0;
    }
    main section form .fieldset {
        width: 100%;
        margin: 2rem 0;
        position: relative;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: flex-start;
    }
    main section form .fieldset label {
        width: 100%;
        margin: 0 0 1rem 0;
        font-size: 1.2rem;
        font-weight: 700;
    }
    main section form .fieldset .input-wrapper {
        width: 100%;
        display: flex;
        flex-flow: nowrap;
        align-items: stretch;
        justify-content: center;
    }
    main section form .fieldset .input-wrapper .icon {
        width: fit-content;
        margin: 0;
        padding: 0.375rem 0.75rem;
        display: flex;
        align-items: center;
        border-top-left-radius: 0.25em;
        border-bottom-left-radius: 0.25em;
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
        border: 0.0625rem solid #ced4da;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        text-align: center;
        background-color: #e9ecef;
    }
    main section form .fieldset .input-wrapper input, main section form .fieldset .input-wrapper select {
        flex-grow: 1;
        min-height: 3rem;
        padding: 0.375rem 0.75rem;
        display: block;
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
        border-top-right-radius: 0.25em;
        border-bottom-right-radius: 0.25em;
        border: 0.0625rem solid #ced4da;
        border-left: 0;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
    }
    main section form .fieldset .input-wrapper:focus .icon, main section form .fieldset .input-wrapper:focus-within .icon, main section form .fieldset .input-wrapper:hover .icon {
        color: #538e46;
    }
    main section form .fieldset:first-child {
        margin-top: 0;
    }
    main section form .fieldset:last-child {
        margin-bottom: 0;
    }
    main section form .actions {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    main section form .actions .lx-btn {
        padding: 0.5rem 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: white;
    cursor: pointer;
    }

    main section form .actions .lx-btn#save {
        color: white !important;
    }

    main section form .actions .lx-btn#cancel, main section form .actions .lx-btn.cancel {
        background-color: #f55;
    }
    main section form .actions .lx-btn#clear, main section form .actions .lx-btn.clear {
        background-color: white;
    }
    main section form .actions .lx-btn#save, main section form .actions .lx-btn.save {
        background-color: #538e46;
    }
    @media screen and (max-width: 64rem) {
        main section .profile-pic {
            max-width: 100%;
            margin: 0;
        }
    }
    @media screen and (max-width: 56.25rem) {
        main section form {
            max-width: 100%;
            margin: 0;
        }
    }

    /* Styling for the gold text */
    .pic-info {
    text-align: center;
    margin-top: 20px;
    }

    .membership-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    font-weight: bold;
    font-size: 14px;
    text-transform: uppercase;
    }

    .gold {
    background-color: #ffc107;
    color: #fff;
    }

    .silver {
    background-color: #c4c4c4;
    color: #fff;
    }

    .bronze {
    background-color: #cd7f32;
    color: #fff;
    }

    .platinum {
    background-color: #e5e4e2;
    color: #0c0c0c;
    border: 2px solid #c0c0c0;
    }
    </style>

    <!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Profile
			</span>
		</div>
	</div>
		
    <main class="has-dflex-center">
        <section>
          <div class="lx-container-70">
            <div class="lx-row">
              <h1 class="title">Edit your profile</h1>
            </div>
            <div class="lx-row align-stretch">
              <div class="lx-column column-user-pic">
                <div class="profile-pic bs-md">
                  <h1 class="pic-label">Profile picture</h1>
                  <div class="pic bs-md">
                    <img src="https://bit.ly/3jRbrbp" alt="" width="4024" height="6048" loading="lazy">
                    <a id="change-avatar" class="lx-btn"><i class="fas fa-camera-retro"></i>&nbsp;&nbsp;Change your profile picture.</a>
                  </div>
                  <div class="pic-info">
					Membership Tier: <span class="membership-badge gold">Gold</span>
					<p>Points Accumulation: 1000</p>
                  </div>
                </div>
              </div>
              <div class="lx-column">
                <form action="get">
                  <div class="fieldset">
                    <label for="user-name">Name</label>
                    <div class="input-wrapper">
                      <span class="icon"><i class="fas fa-user"></i></span>
                      <input type="text" id="user-name" value="Name" autocomplete="username" required>
                    </div>
                    <div id="user-name-helper" class="helper">
                      <p>Your name can appear on the platform, in your contributions or where it is mentioned.</p>
                    </div>
                  </div>
                  <div class="fieldset">
                    <label for="user-id">Registration</label>
                    <div class="input-wrapper">
                      <span class="icon"><i class="fas fa-address-card"></i></span>
                      <input type="number" id="user-id" value="424242" required>
                    </div>
                    <div id="user-id-helper" class="helper"></div>
                  </div>
                  <div class="fieldset">
                    <label for="email">E-mail</label>
                    <div class="input-wrapper">
                      <span class="icon"><i class="fas fa-envelope"></i></span>
                      <input type="email" id="email" value="testing@gmail.com" autocomplete="username">
                    </div>
                    <div id="email-helper" class="helper"></div>
                  </div>
                  <div class="fieldset">
                    <label for="pass">Password</label>
                    <div class="input-wrapper">
                      <span class="icon"><i class="fas fa-key"></i></span>
                      <input type="password" id="pass" value="pass123*" autocomplete="current-password">
                    </div>
                    <div id="pass-helper" class="helper"></div>
                  </div>
                  <div class="actions">
                    <a id="cancel" class="lx-btn"><i class="fas fa-ban"></i>&nbsp;&nbsp;Cancel</a>
                    <a id="clear" class="lx-btn"><i class="fas fa-broom"></i>&nbsp;&nbsp;Clean</a>
                    <a id="save" class="lx-btn"><i class="fas fa-save"></i>&nbsp;&nbsp;Save</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </section>
      </main>
      
      <script src="https://use.fontawesome.com/releases/v5.14.0/js/all.js" defer crossorigin="anonymous" data-search-pseudo-elements></script>

      <br>
@endsection