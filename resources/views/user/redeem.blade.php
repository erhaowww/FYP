@extends('user/master')
@section('content')
    <style>
        /* redeem page css */
        .main {

    margin: 2%;
    }

    .card {
    width: 20%;
    display: inline-block;
    box-shadow: 2px 2px 20px black;
    border-radius: 5px;
    margin: 2%;
    }

    .image img {
    width: 100%;
    border-top-right-radius: 5px;
    border-top-left-radius: 5px;



    }

    .title {

    text-align: center;
    padding: 10px;

    }

    .main h1 {
    font-size: 20px;
    }

    .des {
    padding: 3px;
    text-align: center;

    padding-top: 10px;
    border-bottom-right-radius: 5px;
    border-bottom-left-radius: 5px;
    }

    .main button {
    margin-top: 40px;
    margin-bottom: 10px;
    background-color: white;
    border: 1px solid black;
    border-radius: 5px;
    padding: 10px;
    }

    .main button:hover {
    background-color: black;
    color: white;
    transition: .5s;
    cursor: pointer;
    }
    </style>
    
    <div class="main">
        <!--cards -->
        <div class="card">

            <div class="image">
                <img
                    src="{{asset('user/images/reward1.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->

        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward1.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->


        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward1.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->


        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward1.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->


        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward2.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->

        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward2.png')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->

        <div class="card">

            <div class="image">
                <img
                    src="{{asset('user/images/reward3.jpg')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>

            </div>
        </div>
        <!--cards -->


        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward3.jpg')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
        <!--cards -->


        <div class="card">

            <div class="image">
                <img src="{{asset('user/images/reward3.jpg')}}">
            </div>
            <div class="title">
                <h1>
                    Write title Here</h1>
            </div>
            <div class="des">
                <p>You can Add Desccription Here...</p>
                <button>Read More...</button>
            </div>
        </div>
    </div>
@endsection